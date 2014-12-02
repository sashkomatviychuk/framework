<?php

namespace Kuria\Console\Output\Decorator;

/**
 * Plain decorator class
 *
 * @author ShiraNai7 <shira.cz>
 */
class PlainDecorator implements DecoratorInterface
{
    public function isActive()
    {
        return false;
    }

    public function color($text, $fgColorName, $bgColorName = null)
    {
        return $text;
    }

    public function reset()
    {
        return '';
    }

    public function toggle($state)
    {
        return $this;
    }
}
