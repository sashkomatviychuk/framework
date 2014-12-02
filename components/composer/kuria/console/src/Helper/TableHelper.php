<?php

namespace Kuria\Console\Helper;

use Kuria\Console\Application;
use Kuria\Console\ApplicationAwareInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;

/**
 * Table helper class
 *
 * @author ShiraNai7 <shira.cz>
 */
class TableHelper implements ApplicationAwareInterface
{
    /** Line - full */
    const LINE_FULL = 0;
    /** Line - inner */
    const LINE_INNER_BORDER = 1;
    /** Line - top border */
    const LINE_TOP_BORDER = 2;
    /** Line - bottom border */
    const LINE_BOTTOM_BORDER = 3;

    /** @var OutputHelper */
    private $outputHelper;
    /** @var DecoratorInterface */
    private $decorator;
    /** @var int|null */
    private $columns;
    /** @var int|null */
    private $rows;
    /** @var array */
    private $chars = array(
        'vertical' => "\xB3",
        'vertical-left' => "\xC3",
        'vertical-right' => "\xB4",
        'horizontal' => "\xC4",
        'horizontal-up' => "\xC1",
        'horizontal-down' => "\xC2",
        'horizontal-both' => "\xC5",
        'top-left' => "\xDA",
        'top-right' => "\xBF",
        'bottom-left' => "\xC0",
        'bottom-right' => "\xD9",
    );

    public function setApplication(Application $app)
    {
        $this->outputHelper = $app->getHelper('output');
        $this->decorator = $app->getDecorator();
        $this->columns = $app->getColumns();
        $this->rows = $app->getRows();
    }

    /**
     * Generate a formatted table
     *
     * $rows - each row is a list of values with optional associative parameters:
     * --------------------------------------------------------------------------
     *  fg_color     foreground color of all cells
     *  bg_color     background color of all cells
     *  fg_colors    associative array with foreground color for each cell
     *  bg_colors    associative array with background color for each cell
     *  line         render separating line
     *
     * Example:
     *
     *  $rows = array(
     *      array('First name', 'Last name', 'fg_color' => DecoratorInterface::FG_GREEN),
     *      array('John', 'Smith'),
     *      array('line' => true),
     *      array('Total', 2),
     *  );
     *
     * $options - array of rendering options:
     * --------------------------------------
     *  padding (1)     number of spaces before and after cell content
     *  border (0)      render border 1/0
     *  lines (0)       separate each row with a horizontal line 1/0
     *  columns         associative array of column constraints (see below)
     *
     * Column constraints (columns):
     *
     *  // colnum => constraint
     *  array(
     *      // fixed width
     *      1 => array('width' => 15),
     *
     *      // minimal width
     *      2 => array('min-width' => 10),
     *
     *      // exact-fit (always resize to fit content)
     *      3 => array('exact-fit' => true),
     *  );
     *
     * @param array $rows    array of rows
     * @param array $options associative array of options
     * @return string
     */
    public function table(array $rows, array $options = null)
    {
        // no rows
        if (empty($rows)) {
            return "\n";
        }

        // extract options
        $columnConstraints = (isset($options['columns']) ? $options['columns'] : array());
        $padding = (isset($options['padding']) ? $options['padding'] : 1);
        $border = (isset($options['border']) ? $options['border'] : false);
        $lines = (isset($options['lines']) ? $options['lines'] : false);
        unset($options);

        // analyse table
        list($columns, $columnCount) = $this->analyse($rows, $columnConstraints);
        list(, $outerWidth) = $this->computeWidth($columns, $padding, $border);

        // overlap
        $overlap = $outerWidth - $this->columns;
        if ($overlap > 0) {
            $this->adjustToOverlap($columns, $columnConstraints, $overlap);
        }

        // split rows (overflow, newlines)
        $rows = $this->splitRows($rows, $columns, $columnCount);

        // render
        return $this->renderTable(
            $rows,
            $columns,
            $padding,
            $border,
            $lines
        );
    }

    /**
     * Render table
     *
     * @param array $rows
     * @param array $columns
     * @param int   $padding
     * @param bool  $border
     * @param bool  $lines
     */
    private function renderTable(array $rows, array $columns, $padding, $border, $lines)
    {
        $out = '';

        // top border
        if ($border) {
            $out .= $this->renderLine(self::LINE_TOP_BORDER, $columns, $padding);
        }

        // rows
        $paddingStr = str_repeat(' ', $padding);
        foreach ($rows as $index => $row) {

            if ($lines && !isset($row['_split']) && 0 !== $index) {
                if ($border) {
                    $out .= $this->renderLine(self::LINE_INNER_BORDER, $columns, $padding);
                } else {
                    $out .= $this->renderLine(self::LINE_FULL, $columns, $padding);
                }
            }

            if (isset($row['line']) && $row['line']) {
                $out .= $this->renderLine(
                    $border ? self::LINE_INNER_BORDER : self::LINE_FULL,
                    $columns,
                    $padding
                );
            } else {
                $out .= $this->renderRow(
                    $row,
                    $padding,
                    $paddingStr,
                    $border,
                    $columns
                );
            }

        }

        // bottom border
        if ($border) {
            $out .= $this->renderLine(self::LINE_BOTTOM_BORDER, $columns, $padding);
        }

        return $out;
    }

    /**
     * Render single table row
     *
     * @param array  $row
     * @param int    $padding
     * @param string $paddingStr
     * @param bool   $border
     * @param array  $columns
     */
    private function renderRow(array $row, $padding, $paddingStr, $border, $columns)
    {
        $column = 0;
        $columnCount = sizeof($columns);
        $lastColumn = $columnCount - 1;

        $rowFgColor = (isset($row['fg_color']) ? $row['fg_color'] : null);
        $rowBgColor = (isset($row['bg_color']) ? $row['bg_color'] : null);

        $out = '';
        for ($i = 0; isset($row[$i]); ++$i) {

            $cell = '';

            // content and padding
            $cell .= $paddingStr . $row[$i] . $paddingStr;
            $cellLen = strlen($row[$i]);
            $paddingLen = $columns[$column] - $cellLen;
            if ($paddingLen > 0) {
                $cell .= str_repeat(' ', $paddingLen);
            }

            // colors
            $cellFgColor = (isset($row['fg_colors'][$i]) ? $row['fg_colors'][$i] : $rowFgColor);
            $cellBgColor = (isset($row['bg_colors'][$i]) ? $row['bg_colors'][$i] : $rowBgColor);
            if (null !== $cellFgColor || null !== $cellBgColor) {
                $cell = $this->decorator->color( $cell, $cellFgColor, $cellBgColor);
            }

            // border
            if ($border) {
                $out .= $this->chars['vertical'];
            }

            // output
            $out .= $cell;

            // right border on last column
            if ($border && $i === $lastColumn) {
                $out .= $this->chars['vertical'];
            }

            ++$column;
        }

        // render empty cells
        if ($i < $columnCount) {
            $out .= $this->renderEmptyCells($columns, $padding, $border, $i);
        }

        return $out . "\n";
    }

    /**
     * Render line
     *
     * @param int   $type
     * @param array $columns
     * @param int   $padding
     * @return string
     */
    private function renderLine($type, array $columns, $padding)
    {
        if (self::LINE_FULL === $type) {
            return str_repeat($this->chars['horizontal'], array_sum($columns) + $padding * 2 * sizeof($columns)) . "\n";
        }

        switch ($type) {

            case self::LINE_INNER_BORDER:
                $left = $this->chars['vertical-left'];
                $right = $this->chars['vertical-right'];
                $middle = $this->chars['horizontal-both'];
                break;

            case self::LINE_TOP_BORDER:
                $left = $this->chars['top-left'];
                $right = $this->chars['top-right'];
                $middle = $this->chars['horizontal-down'];
                break;

            case self::LINE_BOTTOM_BORDER:
                $left = $this->chars['bottom-left'];
                $right = $this->chars['bottom-right'];
                $middle = $this->chars['horizontal-up'];
                break;

            default:
                throw new \InvalidArgumentException('Invalid type');

        }

        $out = '';
        for ($i = 0; isset($columns[$i]); ++$i) {
            if (0 === $i) {
                $out .= $left;
            } else {
                $out .= $middle;
            }

            $out .= str_repeat($this->chars['horizontal'], $columns[$i] + $padding * 2);
        }
        $out .= $right . "\n";

        return $out;
    }

    /**
     * Render empty cells
     *
     * @param array    $columns
     * @param int      $padding
     * @param bool     $border
     * @param int      $from
     * @param int|null $to
     * @return string
     */
    private function renderEmptyCells(array $columns, $padding, $border, $from = 0, $to = null)
    {
        $out = '';
        $lastColumn = sizeof($columns) - 1;
        for ($i = $from; isset($columns[$i]) && (null === $to || $i <= $to); ++$i) {
            if ($border) {
                $out .= $this->chars['vertical'] . str_repeat(' ', $columns[$i] + $padding * 2);
                if ($lastColumn === $i) {
                    $out .= $this->chars['vertical'];
                }
            } else {
                $out .= str_repeat(' ', $columns[$i] + $padding * 2);
            }
        }

        return $out;
    }

    /**
     * Analyse table
     *
     * @param array $rows
     * @param array $columnConstraints
     * @return array columns, columnCount
     */
    private function analyse(array $rows, array $columnConstraints)
    {
        $columns = array();
        $columnCount = 0;
        foreach ($rows as $row) {
            $column = 0;
            for ($i = 0; isset($row[$i]); ++$i) {
                if (isset($columnConstraints[$column]['width'])) {
                    $colWidth = $columnConstraints[$column]['width'];
                    $constrained = true;
                } else  {
                    $colWidth = strlen($row[$i]);
                    $constrained = false;
                }
                if (!isset($columns[$column]) || !$constrained && $colWidth > $columns[$column]) {
                    $columns[$column] = $colWidth;
                }
                ++$column;
            }

            if ($column > $columnCount) {
                $columnCount = $column;
            }
        }

        return array($columns, $columnCount);
    }

    /**
     * Compute width of the table
     *
     * @param array $columns
     * @param int   $padding
     * @param bool  $border
     * @return array innerWidth, outerWidth
     */
    private function computeWidth(array $columns, $padding, $border)
    {
        $width = 0;
        for ($i = 0; isset($columns[$i]); ++$i) {
            $width += $columns[$i] + $padding * 2;
        }

        $outerWidth = $width;
        if ($border) {
            $outerWidth += sizeof($columns) + 1;
        }

        $outerWidth += 1; // newline at the end of row

        return array($width, $outerWidth);
    }

    /**
     * Adjust table to avoid the given overlap
     *
     * @param array &$columns
     * @param array $columnConstraints
     * @param int   $overlap
     * @param int   $extraWidth
     */
    private function adjustToOverlap(array &$columns, array $columnConstraints, $overlap)
    {
        // find resizable columns
        $resizableColumns = array();
        $resizableColumnCount = 0;
        $resizableColumnsWidth = 0;

        foreach ($columns as $colNum => $colWidth) {
            if (
                isset($columnConstraints[$colNum]['width'])
                ||
                    isset($columnConstraints[$colNum]['exact-fit'])
                    && $columnConstraints[$colNum]['exact-fit']
            ) {
                // fixed
                $freeWidth = 0;
            } elseif (isset($columnConstraints[$colNum]['min-width'])) {
                // all except min-width past
                $freeWidth = $colWidth - $columnConstraints[$colNum]['min-width'];
            } else {
                // all beyond 1
                $freeWidth = $colWidth - 1;
            }

            if ($freeWidth > 0) {
                $resizableColumns[$colNum] = array(
                    'fixed_width' => $colWidth - $freeWidth,
                    'free_width' => $freeWidth,
                );
                ++$resizableColumnCount;
                $resizableColumnsWidth += $freeWidth;
            }
        }

        // adjust columns
        $currentColumn = 0;
        $extraRatioFromOverlapOverflow = 0;
        foreach ($resizableColumns as $colNum => $colWidths) {
            ++$currentColumn;

            $columnWidthRatio = $colWidths['free_width'] / $resizableColumnsWidth + $extraRatioFromOverlapOverflow;
            $overlapPart = $overlap * $columnWidthRatio;
            $applicableOverlapPart = min(
                $currentColumn === $resizableColumnCount ? ceil($overlapPart) : round(ceil($overlapPart)),
                $colWidths['free_width']
            );

            $columns[$colNum] = $colWidths['fixed_width'] + ($colWidths['free_width'] - $applicableOverlapPart);

            if ($applicableOverlapPart < $overlapPart) {
                $unusedRatio = ($overlapPart - $applicableOverlapPart) / $overlapPart;
                $remainingColumns = $resizableColumnCount - $currentColumn;
                if ($remainingColumns > 0) {
                    $extraRatioFromOverlapOverflow += ($columnWidthRatio * $unusedRatio) / $remainingColumns;
                }
            }
        }
    }

    /**
     * Split table rows
     *
     * @param array $rows
     * @param array $columns
     * @param int   $colCount
     * @return array
     */
    private function splitRows(array $rows, array $columns, $colCount)
    {
        $rowStack = array_reverse($rows);
        $rowQueue = array(array_pop($rowStack));
        $rows = array();
        while (null !== ($row = array_pop($rowQueue))) {

            if (!isset($row['_split'])) {
                $newRows = array();
                for ($i = 0; isset($row[$i]); ++$i) {
                    // split row to lines
                    $rowLines = $this->outputHelper->splitLines($row[$i]);
                    for ($j = 0; isset($rowLines[$j]); ++$j) {
                        // check each line
                        if (strlen($rowLines[$j]) > $columns[$i]) {
                            // split line
                            $splitRows = explode("\n", wordwrap($rowLines[$j], $columns[$i], "\n", true));
                            for ($k = 0; isset($splitRows[$k]); ++$k) {
                                $newRows["@{$j}" . ($k > 0 ? ".{$k}" : '')][$i] = $splitRows[$k];
                            }
                        } else {
                            // use whole line
                            $newRows["@{$j}"][$i] = $rowLines[$j];
                        }
                    }

                }

                if (!empty($newRows)) {

                    // sort split rows
                    uksort($newRows, function ($a, $b) {
                        return -1 * strnatcmp($a, $b);
                    });

                    // add to queue
                    foreach ($newRows as &$newRow) {
                        for ($i = 0; $i < $colCount; ++$i) {
                            if (!isset($newRow[$i])) {
                                $newRow[$i] = '';
                            }
                        }
                        $newRow['_split'] = true;
                        $newRow += $row;
                        $rowQueue[] = $newRow;
                    }
                    $newRows = array();

                    // use row from current position
                    $row = array_pop($rowQueue);
                    unset($row['_split']);
                }
            }

            $rows[] = $row;

            if (empty($rowQueue) && !empty($rowStack)) {
                $rowQueue[] = array_pop($rowStack);
            }

        }

        return $rows;
    }
}
