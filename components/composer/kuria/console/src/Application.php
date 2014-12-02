<?php

namespace Kuria\Console;

use Kuria\Console\Command\Command;
use Kuria\Console\Command\StopException;
use Kuria\Console\Helper\OutputHelper;
use Kuria\Console\Input\InputInterface;
use Kuria\Console\Input\Parser\ArgvParser;
use Kuria\Console\Input\Parser\InputParserInterface;
use Kuria\Console\Output\CliOutput;
use Kuria\Console\Output\Decorator\AnsiDecorator;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\Decorator\PlainDecorator;
use Kuria\Console\Output\OutputInterface;

/**
 * Application class
 *
 * @author ShiraNai7 <shira.cz>
 */
class Application
{
    /** @var OutputInterface */
    protected $output;
    /** @var DecoratorInterface */
    protected $decorator;
    /** @var InputParserInterface */
    protected $inputParser;

    /** @var int|null */
    protected $columns;
    /** @var int|null */
    protected $rows;

    /** @var array */
    private $helpers = array();
    /** @var array */
    private $helperClasses = array();

    /** @var array|null command name => class name */
    private $commands = array();
    /** @var bool */
    private $commandsSorted = false;

    /**
     * Constructor
     *
     * @param InputParserInterface|null $inputParser
     * @param OutputInterface|null      $output
     * @param DecoratorInterface|null   $decorator
     */
    public function __construct(
        InputParserInterface $inputParser = null,
        OutputInterface $output = null,
        DecoratorInterface $decorator = null
    ) {
        // get terminal dimensions
        list($this->columns, $this->rows) = $this->getTerminalDimensions();

        // set decorator
        if (null === $decorator) {
            if ($this->hasColorSupport()) {
                $decorator = new AnsiDecorator();
            } else {
                $decorator = new PlainDecorator();
            }
        }
        $this->decorator = $decorator;

        // set input parser
        $this->inputParser = ($inputParser ?: new ArgvParser());

        // output helper
        $this->addHelper('output', new OutputHelper());

        // set output
        $this->output = ($output ?: new CliOutput($this->decorator, $this->getHelper('output')));

        // set helper classes
        $this
            ->addHelperClass('table', 'Kuria\Console\Helper\TableHelper')
            ->addHelperClass('interaction', 'Kuria\Console\\Helper\InteractionHelper')
            ->addHelperClass('dry_run', 'Kuria\Console\Helper\DryRunHelper')
            ->addHelperClass('usage', 'Kuria\Console\Helper\UsageHelper')
        ;

        $this->setup();
    }

    /**
     * Setup the application
     */
    protected function setup()
    {
        $this->addCommand('help', __NAMESPACE__ . '\Command\HelpCommand');
    }

    /**
     * Get application's name
     *
     * @return string
     */
    public function getName()
    {
        return 'Console Application';
    }

    /**
     * Get application's usage name
     *
     * @return string
     */
    public function getUsageName()
    {
        return 'console';
    }

    /**
     * Run
     *
     * @param mixed $input raw data for the input parser
     * @return int
     */
    public function run($input)
    {
        // parse input
        $input = $this->inputParser->parse($input);

        // apply parameters
        $this->applyParameters($input);

        // determine command name
        $commandName = $this->getCommandNameFromInput($input);

        // match and get command
        try {
            $command = $this->getCommand(
                $this->matchCommand($commandName)
            );
        } catch (\Exception $e) {
            $this->output->writeException($e);

            return 1;
        }

        // run command
        return $this->runCommand($command, $input);
    }

    /**
     * Run command
     *
     * @param Command        $command
     * @param InputInterface $input
     * @return int status code
     */
    protected function runCommand(Command $command, InputInterface $input)
    {
        $code = 0;

        try {

            // reset decorator styles
            $this->output->write($this->decorator->reset());

            // run command
            $commandResult = $command->run($input, $this->output);
            if (is_int($commandResult)) {
                $code = $commandResult;
            }

        } catch (StopException $stopException) {

            // stop exception is ignored

        } catch (\Exception $commandException) {

            // exception while running the command
            $this->output->writeException($commandException);

            // print usage and parameters
            $this->output->writeln();
            $this->getHelper('usage')->printUsage($command, $this->output);
            $this->output->writeln();
            if ($command->hasParameters()) {
                $this->getHelper('usage')->printParameterTable($command, $this->output);
                $this->output->writeln();
            }

            $code = 1;

        }

        return $code;
    }

    /**
     * Get help for application parameters
     *
     * @return array name => description
     */
    public function getParameterHelp()
    {
        return array(
            '--no-decorate' => 'to turn off colors',
            '--no-interact' => 'to disable interaction',
            '--quiet|-q' => 'to surpress output entierly',
            '--verbose|-v' => 'to increase verbosity',
        );
    }

    /**
     * Apply parameters
     *
     * @param InputInterface $input
     */
    protected function applyParameters(InputInterface $input)
    {
        // disable decorator
        if ($input->hasParameter('no-decorate')) {
            $this->decorator->toggle(false);
            $input->removeParameter('no-decorate');
        }

        // disable interactivity
        if ($input->hasParameter('no-interact')) {
            $input
                ->setInteractive(false)
                ->removeParameter('no-interact')
            ;
        }

        // set verbosity
        if ($input->hasParameter('verbose') || $input->hasParameter('-v')) {
            $this->output->setVerbosity(OutputInterface::VERBOSITY_HIGH);
            $input
                ->removeParameter('no-verbose')
                ->removeParameter('-v')
            ;
        } elseif ($input->hasParameter('quiet') || $input->hasParameter('-q')) {
            $this->output->setVerbosity(OutputInterface::VERBOSITY_NONE);
            $input
                ->removeParameter('quiet')
                ->removeParameter('-q')
            ;
        }
    }

    /**
     * Get command name from the given input
     *
     * @param InputInterface $input
     * @return string command name
     */
    protected function getCommandNameFromInput(InputInterface $input)
    {
        if ($input->getArgumentCount() < 1) {
            return $this->getDefaultCommandName();
        } elseif ('' === $input->getArgument(0)) {
            throw new \RuntimeException('Command name not specified');
        } else {
            return $input->shiftArgument();
        }
    }

    /**
     * Get default command name
     *
     * @return string
     */
    protected function getDefaultCommandName()
    {
        return 'help';
    }

    /**
     * Get command instance using class name
     *
     * @param string $commandName command name
     * @throws \RuntimeException
     * @return Command
     */
    public function getCommand($commandName)
    {
        if (!isset($this->commands[$commandName])) {
            throw new \RuntimeException(sprintf('Command "%s" does not exist', $commandName));
        }

        $className = $this->commands[$commandName];

        return new $className($this, $commandName);
    }

    /**
     * Get array of available commands
     *
     * @return array command name => class name
     */
    public function getCommands()
    {
        if (!$this->commandsSorted) {
            $this->sortCommands();
        }
        return $this->commands;
    }

    /**
     * Sort commands
     */
    protected function sortCommands()
    {
        uksort($this->commands, function ($a, $b) {
            $aIsInRoot = (false === strpos($a, ':'));
            $bIsInRoot = (false === strpos($b, ':'));

            if ($aIsInRoot xor $bIsInRoot) {
                if ($aIsInRoot) {
                    return -1;
                } else {
                    return 1;
                }
            } else {
                return strnatcasecmp($a, $b);
            }
        });

        $this->commandsSorted = true;
    }

    /**
     * Add a command
     *
     * @param string $name
     * @param string $className
     * @return Application
     */
    public function addCommand($name, $className)
    {
        $this->commands[$name] = $className;
        $this->commandsSorted = false;

        return $this;
    }

    /**
     * Match single command by name
     *
     * @param string $name
     * @throws \RuntimeException if more than one or none commands matched
     * @return string command name
     */
    public function matchCommand($name)
    {
        $commands = $this->matchCommands($name);

        if (sizeof($commands) > 1) {
            // multiple commands found, try exact match
            $exactMatch = array_search($name, $commands);
            if (false === $exactMatch) {
                throw new \RuntimeException(sprintf(
                    "Multiple commands found for \"%s\". Did you mean one of:\n\n%s",
                    $name,
                    implode("\n", $commands)
                ));
            }

            return $exactMatch;
        } elseif (sizeof($commands) < 1) {
            // no command found
            throw new \RuntimeException(sprintf('Command "%s" was not found', $name));
        }

        return current($commands);
    }

    /**
     * Match commands by name
     *
     * @param string $name
     * @return array list of command names
     */
    public function matchCommands($name)
    {
        // split name
        $nameParts = preg_split('/:|-/', $name);
        $namePartCount = sizeof($nameParts);

        // pre-compute part lengths
        $namePartLengths = array();
        for ($i = 0; $i < $namePartCount; ++$i) {
            $namePartLengths[$i] = strlen($nameParts[$i]);
        }

        // match
        $matches = array();
        foreach ($this->getCommands() as $commandName => $className) {
            $commandNameParts = preg_split('/:|-/', $commandName);
            $commandNamePartCount = sizeof($commandNameParts);
            if ($commandNamePartCount >= $namePartCount) {
                $lastCommandNamePart = $commandNamePartCount - 1;
                for ($i = 0; isset($commandNameParts[$i]) ; ++$i) {
                    if ($i >= $namePartCount) {
                        $matches[] = $commandName;
                        break;
                    } elseif (0 === strncasecmp($nameParts[$i], $commandNameParts[$i], $namePartLengths[$i])) {
                        if ($i === $lastCommandNamePart) {
                            $matches[] = $commandName;
                            break;
                        }
                    } else {
                        break;
                    }
                }
            }
        }

        return $matches;
    }

    /**
     * Get output
     *
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Get decorator
     *
     * @return DecoratorInterface
     */
    public function getDecorator()
    {
        return $this->decorator;
    }

    /**
     * Get input parser
     *
     * @return InputParserInterface
     */
    public function getInputParser()
    {
        return $this->inputParser;
    }

    /**
     * Check for helper
     *
     * @param string $name
     * @return bool
     */
    public function hasHelper($name)
    {
        return isset($this->helpers[$name]) || isset($this->helperClasses[$name]);
    }

    /**
     * Get helper
     *
     * @param string $name
     * @throws \RuntimeException
     * @return object
     */
    public function getHelper($name)
    {
        if (!isset($this->helpers[$name])) {
            $this->lazyLoadHelper($name);
            if (!isset($this->helpers[$name])) {
                throw new \RuntimeException(sprintf('Unknown helper "%s"', $name));
            }
        }

        return $this->helpers[$name];
    }

    /**
     * Add helper
     *
     * @param string $name
     * @param object $instance
     * @return Application
     */
    public function addHelper($name, $instance)
    {
        if (!is_object($instance)) {
            throw new \RuntimeException(sprintf('Helper must be an object, %s given', gettype($instance)));
        }
        if (isset($this->helperClasses[$name])) {
            throw new \RuntimeException(sprintf('Cannot set helper instance for "%s" - helper class with that name is already specified', $name));
        }

        if ($instance instanceof ApplicationAwareInterface) {
            $instance->setApplication($this);
        }
        $this->helpers[$name] = $instance;

        return $this;
    }

    /**
     * Add helper class (lazy load)
     *
     * @param string $name
     * @param string $className
     * @return Application
     */
    public function addHelperClass($name, $className)
    {
        if (isset($this->helpers[$name])) {
            throw new \RuntimeException(sprintf('Cannot set helper class for "%s" - helper instance with that name already exists', $name));
        }

        $this->helperClasses[$name] = $className;

        return $this;
    }

    /**
     * Remove helper
     *
     * @param string $name
     * @return Application
     */
    public function removeHelper($name)
    {
        unset($this->helpers[$name], $this->helperClasses[$name]);

        return $this;
    }

    /**
     * Lazy load a helper instance
     *
     * @param string $name
     * @return bool
     */
    protected function lazyLoadHelper($name)
    {
        if (isset($this->helperClasses[$name])) {
            if (class_exists($this->helperClasses[$name])) {
                $instance = new $this->helperClasses[$name];
                if ($instance instanceof ApplicationAwareInterface) {
                    $instance->setApplication($this);
                }
                $this->helpers[$name] = $instance;
                unset($this->helperClasses[$name]);

                return true;
            } else {
                throw new \RuntimeException(sprintf(
                    'Cannot load helper "%s" - class "%s" does not exist',
                    $name,
                    $this->helpersClasses[$name]
                ));
            }
        }

        return false;
    }

    /**
     * Get columns
     *
     * @return int|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get rows
     *
     * @return int|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Convert camel-cased name to command name
     *
     * @param string $camelCasedName
     * @return string
     */
    protected function camelCaseToCommandName($camelCasedName)
    {
        $out = '';
        $strLen = strlen($camelCasedName);
        $lastChar = null;
        for ($i = 0; $i < $strLen; ++$i) {

            $char = $camelCasedName[$i];
            $ord = ord($char);

            if ($ord > 64 && $ord < 91) {
                if (0 !== $i && '\\' !== $lastChar) {
                    $out .= '-';
                }
                $out .= chr($ord + 32);
            } elseif ('_' === $char) {
                $out .= '-';
            } elseif ('\\' === $char) {
                $out .= ':';
            } else {
                $out .= $char;
            }

            $lastChar = $char;

        }

        return $out;
    }

    /**
     * Detect ANSI color support
     *
     * @return bool
     */
    protected function hasColorSupport()
    {
        return
            DIRECTORY_SEPARATOR !== '\\'
            || false !== getenv('ANSICON')
            || 'ON' === getenv('ConEmuANSI')
        ;
    }

    /**
     * Tries to figure out the terminal dimensions based on the current environment
     * Credit: https://github.com/symfony/Console/blob/master/Application.php
     *
     * @return array width, height
     */
    protected function getTerminalDimensions()
    {
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            // extract [w, H] from "wxh (WxH)"
            if (preg_match('/^(\d+)x\d+ \(\d+x(\d+)\)$/', trim(getenv('ANSICON')), $matches)) {
                return array((int) $matches[1], (int) $matches[2]);
            }
            // extract [w, h] from "wxh"
            if (preg_match('/^(\d+)x(\d+)$/', $this->getConsoleMode(), $matches)) {
                return array((int) $matches[1], (int) $matches[2]);
            }
        }

        if ($sttyString = $this->getSttyColumns()) {
            // extract [w, h] from "rows h; columns w;"
            if (preg_match('/rows.(\d+);.columns.(\d+);/i', $sttyString, $matches)) {
                return array((int) $matches[2], (int) $matches[1]);
            }
            // extract [w, h] from "; h rows; w columns"
            if (preg_match('/;.(\d+).rows;.(\d+).columns/i', $sttyString, $matches)) {
                return array((int) $matches[2], (int) $matches[1]);
            }
        }

        return array(null, null);
    }

    /**
     * Runs and parses stty -a if it's available, suppressing any error output
     * Credit: https://github.com/symfony/Console/blob/master/Application.php
     *
     * @return string
     */
    protected function getSttyColumns()
    {
        if (!function_exists('proc_open')) {
            return;
        }

        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'w'));
        $process = proc_open('stty -a | grep columns', $descriptorspec, $pipes, null, null, array('suppress_errors' => true));
        if (is_resource($process)) {
            $info = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            return $info;
        }
    }

    /**
     * Runs and parses mode CON if it's available, suppressing any error output
     * Credit: https://github.com/symfony/Console/blob/master/Application.php
     *
     * @return string <width>x<height> or null if it could not be parsed
     */
    protected function getConsoleMode()
    {
        if (!function_exists('proc_open')) {
            return;
        }

        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'w'));
        $process = proc_open('mode CON', $descriptorspec, $pipes, null, null, array('suppress_errors' => true));
        if (is_resource($process)) {
            $info = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            if (preg_match('/--------+\r?\n.+?(\d+)\r?\n.+?(\d+)\r?\n/', $info, $matches)) {
                return $matches[2].'x'.$matches[1];
            }
        }
    }
}
