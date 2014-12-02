<?php

namespace Kuria\Console\Command;

use Kuria\Console\Application;
use Kuria\Console\Input\InputInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\OutputInterface;

/**
 * Command class
 *
 * @author ShiraNai7 <shira.cz>
 */
abstract class Command
{
    /** @var Application */
    protected $app;
    /** @var DecoratorInterface */
    protected $decorator;

    /** @var string */
    private $name;
    /** @var int */
    private $minArgs = 0;
    /** @var int|null */
    private $maxArgs = 0;
    /** @var array */
    private $argNames = array();
    /**
     * @var array
     * Entry:
     *  name => array(
     *  alias => string|null
     *      required => bool
     *      default => mixed
     *      name => string
     *      help => string
     *      priority => int
     *  )
     */
    private $params = array();
    /** @var bool */
    private $ignoreExtraParameters = false;
    /** @var string|null */
    private $descr;
    /** @var string|null */
    private $help;
    /** @var bool */
    private $ready = false;

    /**
     * Constructor
     *
     * @param Application $app
     * @param string|null $name
     */
    public function __construct(Application $app, $name = null)
    {
        $this->app = $app;
        $this->name = $name;

        $this->setup();

        if (null !== $this->maxArgs && $this->minArgs > $this->maxArgs) {
            throw new \LogicException('Maximum number of arguments cannot be less than the minimum');
        }

        if (null === $this->name) {
            throw new \LogicException('Command name must be specified');
        }

        $this->validateParameters();
        $this->sortParameters();

        $this->ready = true;
    }

    /**
     * Run the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return mixed
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        return $this->execute(
            new CommandInput($this, $input),
            $output
        );
    }

    /**
     * Setup the command
     */
    protected function setup()
    {
    }

    /**
     * Execute the command's action
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    abstract protected function execute(InputInterface $input, OutputInterface $output);

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Command
     */
    public function setName($name)
    {
        $this->requireNotReady();

        $this->name = $name;

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->descr;
    }

    /**
     * Set description
     *
     * @param string|null $description
     * @return Command
     */
    public function setDescription($description)
    {
        $this->requireNotReady();

        $this->descr = $description;

        return $this;
    }

    /**
     * Get help
     *
     * @return string|null
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * Set help
     *
     * @param string|null $help
     * @return Command
     */
    public function setHelp($help)
    {
        $this->requireNotReady();

        $this->help = $help;

        return $this;
    }

    /**
     * Get minimal number of arguments
     *
     * @return int
     */
    public function getMinArguments()
    {
        return $this->minArgs;
    }

    /**
     * Set minimal number of arguments
     *
     * @param int $minArguments min number of arguments
     * @return Command
     */
    public function setMinArguments($minArguments)
    {
        $this->requireNotReady();

        $this->minArgs = $minArguments;

        return $this;
    }

    /**
     * Get maximal number of arguments
     *
     * @return int|null
     */
    public function getMaxArguments()
    {
        return $this->maxArgs;
    }

    /**
     * Set maximal number of arguments
     *
     * @param int|null $maxArguments max number of arguments (null means no limit)
     * @return Command
     */
    public function setMaxArguments($maxArguments)
    {
        $this->requireNotReady();

        $this->maxArgs = $maxArguments;

        return $this;
    }

    /**
     * Get argument names
     *
     * @return array
     */
    public function getArgumentNames()
    {
        return $this->argNames;
    }

    /**
     * Set argument names
     *
     * @param array $argumentNames
     * @return Command
     */
    public function setArgumentNames(array $argumentNames)
    {
        $this->requireNotReady();

        $this->argNames = $argumentNames;

        return $this;
    }

    /**
     * See if extra parameters should be ignored
     *
     * @return bool
     */
    public function getIgnoreExtraParameters()
    {
        return $this->ignoreExtraParameters;
    }

    /**
     * Set whether extra parameters should be ignored
     *
     * @param bool $ignoreExtraParameters
     * @return Command
     */
    public function setIgnoreExtraParameters($ignoreExtraParameters)
    {
        $this->ignoreExtraParameters = $ignoreExtraParameters;

        return $this;
    }

    /**
     * See if command has any parameters
     *
     * @return bool
     */
    public function hasParameters()
    {
        return !empty($this->params);
    }

    /**
     * Get array of parameters
     *
     * Array in following format:
     *
     * array(
     *      param_name => array(
     *          alias => string|null
     *          required => bool
     *          default => mixed
     *          name => string
     *          help => string
     *          priority => int
     *      ),
     *      ...
     * )
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * Add parameter
     *
     * @param string      $name     parameter name
     * @param string|null $alias    parameter alias
     * @param string      $help     short parameter description
     * @param bool        $required whether the parameter must be specified
     * @param mixed       $default  default value, only allowed if $required = false
     * @param int         $priority parameter's priority (e.g. in parameter list)
     * @throws \LogicException if a default value is specified for required parameter
     * @return Command
     */
    public function addParameter($name, $alias = null, $help = '', $required = true, $default = null, $priority = 0)
    {
        $this->requireNotReady();

        if ($required && null !== $default) {
            throw new \LogicException(sprintf('Cannot specify default value for required parameter "%s"', $name));
        }

        $this->params[$name] = array(
            'alias' => $alias,
            'required' => $required,
            'default' => $default,
            'name' => $name,
            'help' => $help,
            'priority' => $priority,
        );

        return $this;
    }

    /**
     * Modify existing parameter
     *
     * @param string $name
     * @param string $property
     * @param mixed  $newValue
     * @throws \OutOfBoundsException
     * @return Command
     */
    public function modifyParameter($name, $property, $newValue)
    {
        if (!isset($this->params[$name])) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" is not defined', $name));
        }

        if (!array_key_exists($property, $this->params[$name])) {
            throw new \OutOfBoundsException(sprintf('"%s" is not a valid parameter property', $property));
        }

        $this->params[$name][$property] = $newValue;

        return $this;
    }

    /**
     * Get parameter property
     *
     * @param string $name
     * @param string $property
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getParameterProperty($name, $property)
    {
        if (!isset($this->params[$name])) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" is not defined', $name));
        }

        if (!array_key_exists($property, $this->params[$name])) {
            throw new \OutOfBoundsException(sprintf('"%s" is not a valid parameter property', $property));
        }

        return $this->params[$name][$property];
    }

    /**
     * Validate parameters
     */
    private function validateParameters()
    {
        $aliasMap = array();
        foreach ($this->params as $paramName => $param) {
            if (null !== $param['alias']) {
                $aliasMap[$param['alias']][] = $paramName;
            }
        }
        foreach ($aliasMap as $alias => $params) {
            if (sizeof($params) > 1) {
                throw new \RuntimeException(sprintf('Alias "%s" is used by multiple parameters: %s', $alias, implode(', ', $params)));
            }
        }
    }

    /**
     * Sort parameters
     */
    private function sortParameters()
    {
        uasort($this->params, function ($a, $b) {
            if ($a['required'] xor $b['required']) {
                if ($a['required']) {
                    return -1;
                } else {
                    return 1;
                }
            } elseif ($a['priority'] == $b['priority']) {
                return strnatcmp($a['name'], $b['name']);
            } elseif ($a['priority'] > $b['priority']) {
                return -1;
            } else {
                return 1;
            }
        });
    }

    /**
     * Require that the command can be configured
     *
     * @throws \RuntimeException
     */
    protected final function requireNotReady()
    {
        if ($this->ready) {
            throw new \RuntimeException('The command cannot be configured anymore');
        }
    }

    /**
     * Get helper instance
     *
     * @param string $name
     * @return object
     */
    public function getHelper($name)
    {
        return $this->app->getHelper($name);
    }

    /**
     * Get decorator instance
     *
     * @return DecoratorInterface
     */
    public function getDecorator()
    {
        return $this->app->getDecorator();
    }
}
