<?php

namespace Kuria\Console\Helper;

use Kuria\Console\Application;
use Kuria\Console\ApplicationAwareInterface;
use Kuria\Console\Command\Command;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\OutputInterface;

/**
 * Usage helper class
 *
 * @author ShiraNai7 <shira.cz>
 */
class UsageHelper implements ApplicationAwareInterface
{
    /** @var TableHelper */
    private $tableHelper;

    public function setApplication(Application $app)
    {
        $this->tableHelper = $app->getHelper('table');
    }

    /**
     * Print command's usage
     *
     * @param Command         $command
     * @param OutputInterface $output
     * @return UsageHelper
     */
    public function printUsage(Command $command, OutputInterface $output)
    {
        $output
            ->write('USAGE: ', DecoratorInterface::FG_WHITE)
            ->writeln($command->getName() . ' ' . $this->getUsage($command))
        ;

        return $this;
    }

    /**
     * Get command's usage
     *
     * @param Command $command
     * @return string
     */
    public function getUsage(Command $command)
    {
        $decorator = $command->getDecorator();

        // argument settings
        $argNames = $command->getArgumentNames();
        $getArgLabel = function ($index) use ($argNames) {
            return isset($argNames[$index])
                ? $argNames[$index]
                : (is_string($index)
                    ? $index
                    : 'arg' . ($index + 1)
                )
            ;
        };

        // render usage
        $usage = '';
        $firstSegment = true;

        $params = $command->getParameters();
        if (!empty($params)) {
            $usage .= ($firstSegment ? '' : ' ') . '[PARAMETERS]';
            $firstSegment = false;
        }

        $minArgs = $command->getMinArguments();
        $maxArgs = $command->getMaxArguments();

        if (null === $maxArgs) {
            if ($minArgs > 0) {
                for ($i = 0; $i < $minArgs; ++$i) {
                   $usage .= ($firstSegment ? '' : ' ') . "<{$getArgLabel($i)}>";
                   $firstSegment = false;
                }
            } else {
                $usage .= ($firstSegment ? '' : ' ') . "[{$getArgLabel(0)}]";
                $firstSegment = false;
            }
            $usage .= " ... [{$getArgLabel('n')}]";
        } elseif ($maxArgs > 0) {
            for ($i = 0; $i < $maxArgs; ++$i) {
                if ($i < $minArgs) {
                    $arg = "<{$getArgLabel($i)}>";
                } else {
                    $arg = "[{$getArgLabel($i)}]";
                }
                $usage .= ($firstSegment ? '' : ' ') . $decorator->color($arg, DecoratorInterface::FG_WHITE);
                $firstSegment = false;
            }
        }

        return $usage;
    }

    /**
     * Print command parameter table
     *
     * @param Command         $command
     * @param OutputInterface $output
     * @return UsageHelper
     */
    public function printParameterTable(Command $command, OutputInterface $output)
    {
        $params = $this->getParameterTable($command);

        $table = $this->tableHelper->table($params, array(
            'border' => true,
            'lines' => true,
            'columns' => array(
                0 => array('exact-fit' => true),
                1 => array('exact-fit' => true),
            ),
        ));

        $output
            ->writeln('PARAMETERS:', DecoratorInterface::FG_WHITE)
            ->writeln()
            ->writeln($table)
        ;

        return $this;
    }

    /**
     * Get table of command parameters
     *
     * @return array table rows
     */
    public function getParameterTable(Command $command)
    {
        $params = $command->getParameters();

        if (!empty($params)) {
            $rows = array();
            $rows[] = array('Name', 'Default', 'Description', 'fg_color' => DecoratorInterface::FG_GREEN);
            $lastPriority = null;
            foreach ($params as $param) {
                if ($lastPriority !== $param['priority']) {
                    if (null !== $lastPriority) {
                        $rows[] = array();
                    }
                    $lastPriority = $param['priority'];
                }
                $rows[] = array(
                    "--{$param['name']}" . (isset($param['alias']) ? " (-{$param['alias']})" : ''),
                    $param['required'] ? '<required>' : $this->dumpValue($param['default']),
                    $param['help'] ?: '-',
                    'fg_colors' => array(DecoratorInterface::FG_BROWN)
                );
            }

            return $rows;
        } else {
            return array();
        }
    }

    /**
     * Dump a value
     *
     * @param mixed $value
     * @param bool  $isNested
     * @return string
     */
    private function dumpValue($value, $isNested =false)
    {
        if (is_array($value)) {
            if ($isNested || $this->isAssocArray($value)) {
                return 'array(' . sizeof($value) . ')';
            } else {
                $output = '';
                foreach ($value as $key => $item) {
                    if (0 !== $key) {
                        $output .= ', ';
                    }
                    $output .= $this->dumpValue($item, true);
                }

                return $output;
            }
        } elseif (is_object($value)) {
            return '<object>';
        } elseif (is_string($value) && mb_strlen($value) > 16) {
            return var_export(mb_substr($value, 0, 16), true) . '..';
        } else {
            return var_export($value, true);
        }
    }

    /**
     * Check if an array is associative
     *
     * @param array $array
     * @return bool
     */
    private function isAssocArray(array $array)
    {
        $i = 0;
        foreach ($array as $key => $val) {
            if ($key !== $i) {
                return true;
            }
            ++$i;
        }

        return false;
    }
}
