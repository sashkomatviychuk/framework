<?php

namespace Kuria\Console\Input\Parser;

use Kuria\Console\Input\InputInterface;

/**
 * Input parser interface
 *
 * @author ShiraNai7 <shira.cz>
 */
interface InputParserInterface
{
    /**
     * Parse input
     *
     * @param mixed $input
     * @throws InputParserException
     * @return InputInterface
     */
    public function parse($input);
}
