<?php

namespace Kuria\Console\Command;

use Kuria\Console\Input\Input;
use Kuria\Console\Input\InputInterface;

/**
 * Command input class
 *
 * Represents subset of input containing data
 * specific to given Command instance.
 *
 * @author ShiraNai7 <shira.cz>
 */
class CommandInput extends Input
{
    /**
     * Constructor
     *
     * @param Command        $command
     * @param InputInterface $input
     * @throws \RuntimeException
     */
    public function __construct(Command $command, InputInterface $input)
    {
        // extract and validate parameters
        $params = array();
        $inputParams = $input->getParameters();
        $usedParams = array();
        foreach ($command->getParameters() as $commandParamName => $commandParam) {
            if (array_key_exists($commandParamName, $inputParams)) {
                // full name
                $params[$commandParamName] = $inputParams[$commandParamName];
                $usedParams[] = $commandParamName;
            } elseif (null !== $commandParam['alias'] && array_key_exists($commandParamAlias = "-{$commandParam['alias']}", $inputParams)) {
                // alias
                $params[$commandParamName] = $inputParams[$commandParamAlias];
                $usedParams[] = $commandParamAlias;
            } elseif ($commandParam['required']) {
                // missing required
                throw new \RuntimeException(sprintf('Missing required parameter "%s"', $commandParamName));
            } else {
                // use default
                $params[$commandParamName] = $commandParam['default'];
            }
        }

        // detect unknown parameters
        if (!$command->getIgnoreExtraParameters()) {
            $unknownParameters = array_diff(array_keys($inputParams), $usedParams);
            if (!empty($unknownParameters)) {
                throw new \RuntimeException(sprintf('Unknown parameter(s): %s', implode(', ', $unknownParameters)));
            }
        }

        // extract and validate arguments
        $args = $input->getArguments();
        $argCount = sizeof($args);
        if ($argCount < $command->getMinArguments()) {
            throw new \RuntimeException('Not enough arguments');
        }
        if (null !== $command->getMaxArguments() && $argCount > $command->getMaxArguments()) {
            throw new \RuntimeException('Too many arguments');
        }

        // set
        $this->params = $params;
        $this->args = $args;
        $this->interactive = $input->isInteractive();
    }
}
