<?php

namespace Kuria\Console;

use Kuria\Console\Application;

/**
 * Application aware interface
 *
 * @author ShiraNai7 <shira.cz>
 */
interface ApplicationAwareInterface
{
    /**
     * Set application
     *
     * @param Application $app
     */
    public function setApplication(Application $app);
}
