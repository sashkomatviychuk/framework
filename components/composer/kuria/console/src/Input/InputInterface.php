<?php

namespace Kuria\Console\Input;

/**
 * Input interface
 *
 * @author ShiraNai7 <shira.cz>
 */
interface InputInterface extends \IteratorAggregate
{
    /**
     * See if the input is interactive
     *
     * @return bool
     */
    public function isInteractive();

    /**
     * Enable or disable interaction
     *
     * @param bool $interactive
     * @return InputInterface
     */
    public function setInteractive($interactive);

    /**
     * Interact with the input
     *
     * @param mixed $default
     * @return mixed
     */
    public function interact($default = null);

    /**
     * See if the input is empty
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Check for parameter
     *
     * @param string $name
     * @return bool
     */
    public function hasParameter($name);

    /**
     * Set parameter
     *
     * @param string $name
     * @param string $value
     * @return InputInterface
     */
    public function setParameter($name, $value);

    /**
     * Set parameters
     *
     * @param array $parameters array of parameters
     * @return InputInterface
     */
    public function setParameters(array $parameters);

    /**
     * Get parameter
     *
     * @param string $name
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getParameter($name);

    /**
     * Get parameter and convert it to a boolean
     *
     * Accepts one of boolean values: 1, 0, true, false, yes, no, on, off
     * Any other value produces an exception.
     *
     * @param string $name
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function getBooleanParameter($name);

    /**
     * Get parameter and convert it to an integer
     *
     * @param string $name
     * @throws \UnexpectedValueException
     * @return int
     */
    public function getIntegerParameter($name);

    /**
     * Get parameter and convert it to a float
     *
     * @param string $name
     * @throws \UnexpectedValueException
     * @return float
     */
    public function getFloatParameter($name);

    /**
     * Parse comma-delimited list
     *
     * @param string $name
     * @throws \UnexpectedValueException
     * @return array
     */
    public function getListParameter($name);

    /**
     * Get parameter and match it against a list of possible choices
     *
     * @param string $name
     * @param array  $choices
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function getChoiceParameter($name, array $choices);

    /**
     * Parse comma-delimited list and match it against a list of possible choices
     *
     * @param string $name
     * @param array  $choices
     * @throws \UnexpectedValueException
     * @return array
     */
    public function getChoiceListParameter($name, array $choices);

    /**
     * Get parameter position
     *
     * @param string $name
     * @throws \UnexpectedValueException
     * @return int
     */
    public function getParameterPosition($name);

    /**
     * Get all parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * Get number of parameters
     *
     * @return int
     */
    public function getParameterCount();

    /**
     * Remove parameter
     *
     * @param string $name
     * @return InputInterface
     */
    public function removeParameter($name);

    /**
     * Check for argument
     *
     * @param int $index
     * @return bool
     */
    public function hasArgument($index);

    /**
     * Add argument
     *
     * @param mixed $argument
     * @return InputInterface
     */
    public function addArgument($argument);

    /**
     * Set arguments
     *
     * @param array $arguments list of arguments
     * @return InputInterface
     */
    public function setArguments(array $arguments);

    /**
     * Get argument at the given index
     *
     * @param int $index
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function getArgument($index);

    /**
     * Get all arguments
     *
     * @return array
     */
    public function getArguments();

    /**
     * Get slice of arguments
     *
     * @param int      $offset
     * @param int|null $length
     * @return array
     */
    public function sliceArguments($offset, $length = null);

    /**
     * Shift an argument off the beginning of the argument list
     *
     * @return mixed
     */
    public function shiftArgument();

    /**
     * Pop an argument off the end of the argument list
     *
     * @return mixed
     */
    public function popArgument();

    /**
     * Get number of arguments
     *
     * @return int
     */
    public function getArgumentCount();
}
