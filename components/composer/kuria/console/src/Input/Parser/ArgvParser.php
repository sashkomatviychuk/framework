<?php

namespace Kuria\Console\Input\Parser;

use Kuria\Console\Input\Input;

/**
 * Argv parser class
 *
 * @author ShiraNai7 <shira.cz>
 */
class ArgvParser implements InputParserInterface
{
    public function parse($argv)
    {
        if (!is_array($argv) || sizeof($argv) < 1) {
            throw new \InvalidArgumentException('Invalid argv input');
        }
        array_shift($argv);

        $input = new Input();
        foreach ($argv as $argIndex => $argValue) {

            if ('-' === substr($argValue, 0, 1)) {
                // parameter
                list($paramName, $paramValue) = $this->parseParameter($argIndex, $argValue);
                $input->setParameter($paramName, $paramValue);
            } else {
                // argument
                $input->addArgument($argValue);
            }

        }

        return $input;
    }

    /**
     * Parse parameter
     *
     * @param int    $argIndex
     * @param string $argValue
     * @return array name, value
     */
    protected function parseParameter($argIndex, $argValue)
    {
        $paramIsLong = ('--' === substr($argValue, 0, 2));

        if ($paramIsLong) {
            // parse long parameter
            $equalSymbolPos = strpos($argValue, '=');
            if (false === $equalSymbolPos) {
                // no value
                $paramName = substr($argValue, 2);
                $paramValue = true;
            } else {
                $paramName = substr($argValue, 2, $equalSymbolPos - 2);
                $paramValue = substr($argValue, $equalSymbolPos + 1);
            }
        } else {
            // parse short parameter
            $paramName = substr($argValue, 0, 2);
            if (strlen($argValue) > 2) {
                $paramValue = substr($argValue, 2);
            } else {
                $paramValue = true;
            }
        }

        // validate
        if ('' === $paramName || false === $paramName || !$paramIsLong && '-' === $paramName) {
            throw new InputParserException(sprintf('Parameter name cannot be empty (%s)', $argIndex));
        }
        if ($paramIsLong && '-' === $paramName[0]) {
            throw new InputParserException(sprintf('Illegal parameter name "--%s"', $paramName));
        }

        return array($paramName, $paramValue);
    }
}
