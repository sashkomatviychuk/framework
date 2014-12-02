<?php

namespace Kuria\Console\Output;

/**
 * Output interface
 *
 * @author ShiraNai7 <shira.cz>
 */
interface OutputInterface
{
    /** Verbosity - */
    const VERBOSITY_NONE = 0;
    /** Verbosity - normal */
    const VERBOSITY_NORMAL = 1;
    /** Verbosity - high */
    const VERBOSITY_HIGH = 2;

    /**
     * Output a string
     *
     * @param string      $str
     * @param string|null $color
     * @return OutputInterface
     */
    public function write($str, $fgColor = null, $bgColor = null);

    /**
     * Output a string plus a newline character
     *
     * @param string      $line
     * @param string|null $fgColor
     * @param string|null $bgColor
     * @param int         $level
     * @return OutputInterface
     */
    public function writeln($line = '', $fgColor = null, $bgColor = null, $level = 0);

    /**
     * Output an exception
     *
     * @param \Exception $e
     * @return OutputInterface
     */
    public function writeException(\Exception $e);

    /**
     * Set output verbosity
     *
     * @param int $verbosity
     * @return OutputInterface
     */
    public function setVerbosity($verbosity);

    /**
     * Get output verbosity
     *
     * @return int
     */
    public function getVerbosity();

    /**
     * Checks if verbosity is set to the the given level
     *
     * @param int $verbosity
     */
    public function verbosityIs($verbosity);
}
