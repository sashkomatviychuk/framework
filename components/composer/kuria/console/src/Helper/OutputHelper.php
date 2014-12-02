<?php

namespace Kuria\Console\Helper;

use Kuria\Console\Application;
use Kuria\Console\ApplicationAwareInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;

/**
 * Output helper class
 *
 * @author ShiraNai7 <shira.cz>
 */
class OutputHelper implements ApplicationAwareInterface
{
    /** @var DecoratorInterface */
    private $decorator;
    /** @var int|null */
    private $columns;
    /** @var int|null */
    private $rows;

    public function setApplication(Application $app)
    {
        $this->decorator = $app->getDecorator();
        $this->columns = $app->getColumns();
        $this->rows = $app->getRows();
    }

    /**
     * Format lines of a string according to the given options
     *
     * Supported options
     * -----------------
     * prefix       string to prepend to each line
     * suffix       string to append to each line
     * expand       expand whitespace to match the longest line
     * wrap         split lines that exceed available space
     * fg_color     foreground color to apply to each line
     * bg_color     background color to apply to each line
     *
     * @param string $str
     * @param array  $opts
     * @return string
     */
    public function formatLines($str, array $opts)
    {
        $opts += array(
            'prefix' => '',
            'suffix' => '',
            'expand' => false,
            'wrap' => false,
            'fg_color' => null,
            'bg_color' => null,
        );
        $color = (null !== $opts['fg_color'] || null !== $opts['bg_color']);
        $lines = array_reverse($this->splitLines($str));

        $wrapLen = null;
        if ($opts['wrap'] && null !== $this->columns) {
            $wrapLen = $this->columns - 1;
        }

        if (null !== $wrapLen) {
            $wrapLen -= strlen($opts['prefix']) + strlen($opts['suffix']);
        }

        if ($opts['expand']) {
            $maxLineLen = max(array_map('strlen', $lines));
            if (null !== $wrapLen && $maxLineLen > $wrapLen) {
                $maxLineLen = $wrapLen;
            }
        }

        $out = '';
        $lineQueue = array(array_pop($lines));
        while (null !== ($line = array_pop($lineQueue))) {

            $lineLen = strlen($line);

            // split into multiple lines if too long
            if (null !== $wrapLen && $lineLen > $wrapLen) {
                $splitLines = explode("\n", wordwrap($line, $wrapLen, "\n", true));
                for ($i = (sizeof($splitLines) - 1); $i >= 0; --$i) {
                    $lineQueue[] = $splitLines[$i];
                }
                continue;
            }

            // expand whitespace
            if ($opts['expand'] && $lineLen < $maxLineLen) {
                $line = $opts['prefix'] . $line . str_repeat(' ', $maxLineLen - $lineLen) . $opts['suffix'];
            } else{
                $line = $opts['prefix'] . $line . $opts['suffix'];
            }

            // add to output
            if ($color) {
                $out .= $this->decorator->color($line, $opts['fg_color'], $opts['bg_color']);
            } else {
                $out .= $line;
            }

            if (empty($lineQueue)) {
                if (empty($lines)) {
                    break;
                }
                $lineQueue[] = array_pop($lines);
            }

            $out .= PHP_EOL;
        }

        return $out;
    }

    /**
     * Split string into lines
     *
     * @param string $str
     * @return array array of lines
     */
    public function splitLines($str)
    {
        return preg_split('/\n|\r\n?/', $str);
    }
}
