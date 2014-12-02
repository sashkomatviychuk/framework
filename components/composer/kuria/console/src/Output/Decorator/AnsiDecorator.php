<?php

namespace Kuria\Console\Output\Decorator;

/**
 * Ansi decorator class
 *
 * @author ShiraNai7 <shira.cz>
 */
class AnsiDecorator implements DecoratorInterface
{
    protected
        /** @var bool */
        $state = true,
        /** @var array foreground colors */
        $fgColors = array(
            self::FG_BLACK => '0;30',
            self::FG_DARK_GRAY => '1;30',
            self::FG_BLUE => '0;34',
            self::FG_LIGHT_BLUE => '1;34',
            self::FG_GREEN => '0;32',
            self::FG_LIGHT_GREEN => '1;32',
            self::FG_CYAN => '0;36',
            self::FG_LIGHT_CYAN => '1;36',
            self::FG_RED => '0;31',
            self::FG_LIGHT_RED => '1;31',
            self::FG_PURPLE => '0;35',
            self::FG_LIGHT_PURPLE => '1;35',
            self::FG_BROWN => '0;33',
            self::FG_YELLOW => '1;33',
            self::FG_LIGHT_GRAY => '0;37',
            self::FG_WHITE => '1;37',
        ),
        /** @var array background colors */
        $bgColors = array(
            self::BG_BLACK => '40',
            self::BG_RED => '41',
            self::BG_GREEN => '42',
            self::BG_YELLOW => '43',
            self::BG_BLUE => '44',
            self::BG_MAGENTA => '45',
            self::BG_CYAN => '46',
            self::BG_LIGHT_GRAY => '47',
        ),
        /** @var string */
        $e = "\x1B",
        /** @var string */
        $bel = "\x7"
    ;

    public function isActive()
    {
        return $this->state;
    }

    public function color($text, $fgColorName, $bgColorName = null)
    {
        if (!$this->state) {
            return $text;
        }
        $output = '';
        if (null !== $fgColorName) {
            $output .= $this->colorSequence($this->getFgColorCode($fgColorName));
        }
        if (null !== $bgColorName) {
            $output .= $this->colorSequence($this->getBgColorCode($bgColorName));
        }
        $output .= $text . $this->reset();

        return $output;
    }

    public function reset()
    {
        if (!$this->state) {
            return '';
        }
        return $this->e . '[0m';
    }

    public function toggle($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Compose sequence to define color
     *
     * @param string $colorCode
     * @return string
     */
    protected function colorSequence($colorCode)
    {
        return $this->e . '[' . $colorCode . 'm';
    }

    /**
     * Get foreground color code
     *
     * @param string $colorName
     * @return string
     */
    protected function getFgColorCode($colorName)
    {
        if (!isset($this->fgColors[$colorName])) {
            throw new \InvalidArgumentException(sprintf('Unknown foreground color "%s"', $colorName));
        }

        return $this->fgColors[$colorName];
    }

    /**
     * Get background color code
     *
     * @param string $colorName
     * @return string
     */
    protected function getBgColorCode($colorName)
    {
        if (!isset($this->bgColors[$colorName])) {
            throw new \InvalidArgumentException(sprintf('Unknown background color "%s"', $colorName));
        }

        return $this->bgColors[$colorName];
    }
}
