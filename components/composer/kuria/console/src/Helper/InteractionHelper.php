<?php

namespace Kuria\Console\Helper;

use Kuria\Console\Input\InputInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\OutputInterface;

/**
 * Interaction helper class
 *
 * @author ShiraNai7 <shira.cz>
 */
class InteractionHelper
{
    /**
     * Get input from the user
     *
     * @param InputInterface  $input   input instance
     * @param OutputInterface $output  output instance
     * @param string          $prompt  a prompt WITHOUT colon
     * @param mixed           $default default value
     * @return mixed
     */
    public function prompt(InputInterface $input, OutputInterface $output, $prompt, $default = null)
    {
        return $this->doInteract(
            $input,
            $output,
            $prompt . ':',
            null,
            $default,
            $default
        );
    }

    /**
     * Ask a yes or no question
     *
     * @param InputInterface  $input              input instance
     * @param OutputInterface $output             output instance
     * @param string          $question           a question INCLUDING the question mark
     * @param bool            $default            default value (true or false)
     * @param bool            $defaultNonInteract default value (true or false) if the input is not interactive
     * @return bool
     */
    public function ask(InputInterface $input, OutputInterface $output, $question, $default, $defaultNonInteract)
    {
        $default = ($default ? 'y' : 'n');
        $defaultNonInteract = ($defaultNonInteract ? 'y' : 'n');
        do {
            $result = $this->doInteract(
                $input,
                $output,
                $question,
                '(y/n) [' . $default . ']',
                $default,
                $defaultNonInteract
            );
        } while (!in_array($result, array('y', 'n'), true));

        return 'y' === $result;
    }

    /**
     * Interact with the input
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $prompt
     * @param string          $suffix
     * @param string          $default
     * @param string          $defaultNonInteract
     */
    private function doInteract(InputInterface $input, OutputInterface $output, $prompt, $suffix, $default, $defaultNonInteract)
    {
        $output->write($prompt, DecoratorInterface::FG_BLACK, DecoratorInterface::BG_CYAN);
        if ($suffix) {
            $output
                ->write(' ')
                ->write($suffix, DecoratorInterface::FG_GREEN)
            ;
        }
        $output->write(' ');

        if ($input->isInteractive()) {
            return $input->interact($default);
        } else {
            $output->writeln($defaultNonInteract);

            return $defaultNonInteract;
        }
    }
}
