<?php

namespace Kuria\Console\Helper;

use Kuria\Console\Application;
use Kuria\Console\ApplicationAwareInterface;
use Kuria\Console\Command\Command;
use Kuria\Console\Command\StopException;
use Kuria\Console\Input\InputInterface;
use Kuria\Console\Output\Decorator\DecoratorInterface;
use Kuria\Console\Output\OutputInterface;

/**
 * Dry run helper class
 *
 * @author ShiraNai7 <shira.cz>
 */
class DryRunHelper implements ApplicationAwareInterface
{
    /** @var InteractionHelper */
    private $interaction;

    public function setApplication(Application $app)
    {
        $this->interaction = $app->getHelper('interaction');
    }

    /**
     * Add dry run parameter to a command
     *
     * @param Command     $command command instance
     * @param string|null $help    custom help text
     */
    public function addParameter(Command $command, $help = null)
    {
        if (null == $help) {
            $help = 'dry run mode (does not change anything, enabled by default)';
        }

        $command->addParameter('dry-run', 'd', $help, false, true, 10);
    }

    /**
     * Get dry run state
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param bool            $confirmIfNotDryRun
     * @throws StopException if the dry run is not confirmed
     */
    public function getParameter(InputInterface $input, OutputInterface $output, $confirmIfNotDryRun = true)
    {
        $dryRun = $input->getBooleanParameter('dry-run');

        if ($confirmIfNotDryRun && !$dryRun) {
            $confirmation = $this->interaction->ask(
                $input,
                $output,
                'Warning! Dry run mode is off. Changes will be made. Continue?',
                false,
                true
            );

            if (!$confirmation) {
                $output->writeln('Cancelled', DecoratorInterface::FG_RED);

                throw new StopException();
            } else {
                $output->writeln();
            }
        }

        if ($dryRun) {
            $output
                ->write('dry-run', DecoratorInterface::FG_BROWN)
                ->write(' is ')
                ->write('enabled', DecoratorInterface::FG_GREEN)
                ->writeln(' (no changes will be made)')
                ->writeln()
            ;
        }

        return $dryRun;
    }
}
