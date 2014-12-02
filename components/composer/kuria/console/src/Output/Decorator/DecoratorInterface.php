<?php

namespace Kuria\Console\Output\Decorator;

/**
 * Decorator interface
 *
 * @author ShiraNai7 <shira.cz>
 */
interface DecoratorInterface
{
    const
        // foreground colors
        FG_BLACK = 'black',
        FG_DARK_GRAY = 'dark_gray',
        FG_BLUE = 'blue',
        FG_LIGHT_BLUE = 'light_blue',
        FG_GREEN = 'green',
        FG_LIGHT_GREEN = 'light_green',
        FG_CYAN = 'cyan',
        FG_LIGHT_CYAN = 'light_cyan',
        FG_RED = 'red',
        FG_LIGHT_RED = 'light_red',
        FG_PURPLE = 'purple',
        FG_LIGHT_PURPLE = 'light_purple',
        FG_BROWN = 'brown',
        FG_YELLOW = 'yellow',
        FG_LIGHT_GRAY = 'light_gray',
        FG_WHITE = 'white',

        // background colors
        BG_BLACK = 'black',
        BG_RED = 'red',
        BG_GREEN = 'green',
        BG_YELLOW = 'yellow',
        BG_BLUE = 'blue',
        BG_MAGENTA = 'magenta',
        BG_CYAN = 'cyan',
        BG_LIGHT_GRAY = 'light_gray'
    ;

    /**
     * See if the decorator is active.
     * Being active means that it supports colors, etc.
     * and is not currently in disabled state.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Color a string
     *
     * @param string      $str         the string to color
     * @param string|null $fgColorName foreground color name
     * @param string|null $bgColorName background color name
     * @return string
     */
    public function color($text, $fgColorName, $bgColorName = null);

    /**
     * Compose reset sequence
     *
     * @return string
     */
    public function reset();

    /**
     * Toggle decorator state
     *
     * @param bool $state enabledor disabled
     * @return DecoratorInterface
     */
    public function toggle($state);
}
