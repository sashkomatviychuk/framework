<?php

namespace Kuria\Console\Input;

/**
 * Input class
 *
 * @author ShiraNai7 <shira.cz>
 */
class Input implements InputInterface
{
    protected
        /** @var array */
        $params = array(),
        /** @var array */
        $args = array(),
        /** @var bool */
        $interactive = true
    ;

    public function interact($default = null)
    {
        if ($this->interactive) {
            $line = stream_get_line(STDIN, 1024, PHP_EOL);
            if ('' === $line) {
                return $default;
            } else {
                return $line;
            }
        } else {
            return $default;
        }
    }

    public function setInteractive($interactive)
    {
        $this->interactive = $interactive;

        return $this;
    }

    public function isInteractive()
    {
        return $this->interactive;
    }

    public function isEmpty()
    {
        return empty($this->params) && empty($this->args);
    }

    public function hasParameter($name)
    {
        return isset($this->params[$name]) || array_key_exists($name, $this->params);
    }

    public function setParameter($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->params = $parameters;

        return $this;
    }

    public function getParameter($name)
    {
        if (!isset($this->params[$name]) && !array_key_exists($name, $this->params)) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" is not defined', $name));
        }

        return $this->params[$name];
    }

    public function getBooleanParameter($name)
    {
        $value = $this->getParameter($name);

        if (is_bool($value)) {
            return $value;
        }

        switch ($value) {

            case '1':
            case 'true':
            case 'on':
            case 'yes':
            case 'y':
                return true;

            case 'false':
            case 'off':
            case 'no':
            case 'n':
                return false;

            default:
                if ('0' === $value) {
                    // special case (switch uses loose comparison)
                    return false;
                }
                throw new \UnexpectedValueException(sprintf('"%s" is not a valid boolean value', $value));

        }
    }

    public function getIntegerParameter($name)
    {
        $value = $this->getParameter($name);
        if (!is_int($value) && !ctype_digit($value)) {
            throw new \UnexpectedValueException(sprintf('"%s" is not a valid integer value', $value));
        }

        return (int) $value;
    }

    public function getFloatParameter($name)
    {
        $value = $this->getParameter($name);
        if (!is_float($value) && !preg_match('/^[0-9]+(\\.[0-9]+)?$/')) {
            throw new \UnexpectedValueException(sprintf('"%s" is not a valid float value', $value));
        }

        return (float) $value;
    }

    public function getListParameter($name)
    {
        $value = $this->getParameter($name);

        if (!is_array($value)) {
            $list = preg_split('/\\s*,\\s*/', $value, null, PREG_SPLIT_NO_EMPTY);
        } else {
            $list = $value;
        }

        return $list;
    }

    public function getChoiceParameter($name, array $choices)
    {
        $value = $this->getParameter($name);

        if (!in_array($value, $choices)) {
            throw new \UnexpectedValueException(sprintf(
                'Parameter "%s" has invalid value: "%s". Valid values are: %s',
                $name,
                $value,
                implode(' ', $choices)
            ));
        }

        return $value;
    }

    public function getChoiceListParameter($name, array $choices)
    {
        $list = $this->getListParameter($name);
        
        if ($diff = array_diff($list, $choices)) {
            throw new \UnexpectedValueException(sprintf(
                'Parameter "%s" contains invalid values: %s',
                $name,
                implode(', ', $diff)
            ));
        }

        return $list;
    }

    public function getParameterPosition($name)
    {
        $position = array_search($name, array_keys($this->params), true);
        if (false === $position) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" is not defined', $name));
        }

        return $position;
    }

    public function getParameters()
    {
        return $this->params;
    }

    public function getParameterCount()
    {
        return sizeof($this->params);
    }

    public function removeParameter($name)
    {
        unset($this->params[$name]);

        return $this;
    }

    public function hasArgument($index)
    {
        return isset($this->args[$index]);
    }

    public function addArgument($argument)
    {
        $this->args[] = $argument;

        return $this;
    }

    public function setArguments(array $arguments)
    {
        $this->args = $arguments;

        return $this;
    }

    public function getArgument($index)
    {
        if (!isset($this->args[$index])) {
            throw new \OutOfBoundsException(sprintf('Argument "%s" is not defined', $index));
        }

        return $this->args[$index];
    }

    public function getArguments()
    {
        return $this->args;
    }

    public function sliceArguments($offset, $length = null)
    {
        return array_slice($this->args, $offset, $length);
    }

    public function shiftArgument()
    {
        return array_shift($this->args);
    }

    public function popArgument()
    {
        return array_pop($this->args);
    }

    public function getArgumentCount()
    {
        return sizeof($this->args);
    }

    /**
     * Get argument iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->args);
    }
}
