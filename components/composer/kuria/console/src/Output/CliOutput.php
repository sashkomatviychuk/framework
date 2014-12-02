<?php

namespace Kuria\Console\Output;

use Kuria\Console\Helper\OutputHelper;
use Kuria\Console\Output\Decorator\DecoratorInterface;

/**
 * Cli output class
 *
 * @author ShiraNai7 <shira.cz>
 */
class CliOutput implements OutputInterface
{
    protected
        /** @var DecoratorInterface */
        $decorator,
        /** @var OutputHelper */
        $helper,
        /** @var int */
        $verbosity = self::VERBOSITY_NORMAL
    ;

    /**
     * Constructor
     *
     * @param DecoratorInterface $decorator
     * @param OutputHelper       $helper
     */
    public function __construct(DecoratorInterface $decorator, OutputHelper $helper)
    {
        $this->decorator = $decorator;
        $this->helper = $helper;
    }

    public function write($str, $fgColor = null, $bgColor = null)
    {
        if (self::VERBOSITY_NONE !== $this->verbosity) {
            if (null === $fgColor && null === $bgColor) {
                echo $str;
            } else {
                echo $this->decorator->color($str, $fgColor, $bgColor);
            }
        }

        return $this;
    }

    public function writeln($line = '', $fgColor = null, $bgColor = null, $level = 0)
    {
        if (self::VERBOSITY_NONE !== $this->verbosity) {
            echo
                ($level > 0) ? str_repeat("\t", $level) : '',
                (null !== $fgColor || null !== $bgColor) ? $this->decorator->color($line, $fgColor, $bgColor) : $line,
                PHP_EOL
            ;
        }

        return $this;
    }

    public function writeException(\Exception $e)
    {
        do {
            $this->doWriteException($e);
        } while($e = $e->getPrevious());

        return $this;
    }

    /**
     * Render single exception
     *
     * @param \Exception $e
     */
    protected function doWriteException(\Exception $e)
    {
        $this
            ->writeln()
            ->write(
                $this->helper->formatLines(
                    "\n{$e->getMessage()}\n",
                    array(
                        'prefix' => ($this->decorator->isActive() ? ' ' : ' ERROR! '),
                        'suffix' => ' ',
                        'expand' => true,
                        'wrap' => true,
                        'fg_color' => DecoratorInterface::FG_WHITE,
                        'bg_color' => DecoratorInterface::BG_RED,
                    )
                )
            )
            ->writeln()
        ;

        if (self::VERBOSITY_HIGH === $this->verbosity) {
            $this
                ->writeln()
                ->write(
                    $this->helper->formatLines(
                        "\n[" . get_class($e) . "] in {$e->getFile()} on line {$e->getLine()}\n\n{$e->getTraceAsString()}\n",
                        array(
                            'prefix' => ' ',
                            'suffix' => ' ',
                            'expand' => true,
                            'wrap' => true,
                            'fg_color' => DecoratorInterface::FG_LIGHT_GRAY,
                            'bg_color' => DecoratorInterface::BG_BLUE,
                        )
                    )
                )
                ->writeln()
            ;
        }
    }

    public function getVerbosity()
    {
        return $this->verbosity;
    }

    public function setVerbosity($verbosity)
    {
        $this->verbosity = $verbosity;

        return $this;
    }

    public function verbosityIs($verbosity)
    {
        return $this->verbosity === $verbosity;
    }
}
