<?php

namespace Kuria\Console\Command;

use Kuria\Console\Input\InputInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\OutputInterface;

/**
 * Help command class
 *
 * @author ShiraNai7 <shira.cz>
 */
class HelpCommand extends Command
{
    protected function setup()
    {
        $this
            ->setName('help')
            ->setDescription('Displays help')
            ->setMaxArguments(null)
            ->setIgnoreExtraParameters(true)
            ->setArgumentNames(array('command'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasArgument(0)) {
            $this->helpForCommand($input->getArgument(0), $output);
        } else {
            $this->help($output);
        }
    }

    /**
     * Show main help and list commands
     */
    private function help(OutputInterface $output)
    {
        // app name and usage
        $output
            ->writeln()
            ->writeln($this->app->getName(), DecoratorInterface::FG_WHITE)
            ->writeln()

            ->write('USAGE:', DecoratorInterface::FG_WHITE)
            ->writeln(" {$this->app->getUsageName()} [command-name] [arg1] ... [--param=value] [-pvalue]")
            ->writeln()
        ;

        // help command usage
        $output
            ->write('HELP:', DecoratorInterface::FG_WHITE)
            ->writeln(' run help [command-name]  to display help for the given command')
            ->writeln()
        ;

        // app parameters
        $appParameterRows = array();
        foreach ($this->app->getParameterHelp() as $paramName => $paramHelp) {
            $appParameterRows[] = array(
                'set',
                $paramName,
                $paramHelp,
                'fg_colors' => array(1 => DecoratorInterface::FG_BROWN)
            );
        }
        if (!empty($appParameterRows)) {
            $output->writeln($this->getHelper('table')->table($appParameterRows));
        }

        // list commands
        $output
            ->writeln('AVAILABLE COMMANDS:', DecoratorInterface::FG_WHITE)
            ->writeln()
        ;

        $lastCategory = null;

        $rows = array();
        $rows[] = array('Category', 'Command', 'Description', 'fg_color' => DecoratorInterface::FG_BROWN);
        $rows[] = array();

        foreach ($this->app->getCommands() as $commandName => $className) {

            $command = $this->app->getCommand($commandName);
            $commandParts = explode(':', $commandName, 2);
            $category = (isset($commandParts[1]) ? $commandParts[0] : 'main');

            if ($lastCategory !== $category && null !== $lastCategory) {
                $rows[] = array();
            }

            $rows[] = array(
                ($lastCategory !== $category) ? $category : '',
                $commandName,
                $command->getDescription(),
                'fg_colors' => array(
                    DecoratorInterface::FG_DARK_GRAY,
                    DecoratorInterface::FG_WHITE,
                ),
            );

            $lastCategory = $category;
        }

        $output
            ->write($this->getHelper('table')->table($rows, array(
                'columns' => array(
                    0 => array('exact-fit' => true),
                    1 => array('exact-fit' => true),
                )
            )))
            ->writeln()
        ;

        // command name matching
        $output
            ->writeln('COMMAND NAME MATCHING:', DecoratorInterface::FG_WHITE)
            ->writeln()
            ->writeln('Partial command names are supported. All parts delimited by ":" or "-" can be specified only partially.')
            ->writeln('For example: ex:fo-ba matches example:foo-bar.')
        ;
    }

    /**
     * Display help for single command
     *
     * @param string $commandName
     */
    private function helpForCommand($commandName, OutputInterface $output)
    {
        $usageHelper = $this->getHelper('usage');

        $command = $this->app->getCommand(
            $this->app->matchCommand($commandName)
        );

        // usage
        $output->writeln();
        $usageHelper->printUsage($command, $output);
        $output->writeln();

        // description
        if ($command->getDescription()) {
            $output
                ->write('DESCRIPTION: ', DecoratorInterface::FG_WHITE)
                ->write($command->getDescription())
                ->writeln()
            ;
        }

        // parameters
        if ($command->hasParameters()) {
            $usageHelper->printParameterTable($command, $output);
            $output->writeln();
        }

        // help
        $help = $command->getHelp();
        if (!empty($help)) {
            $output
                ->writeln('HELP:', DecoratorInterface::FG_WHITE)
                ->writeln()
                ->write($help)
                ->writeln()
            ;
        }
    }
}
