<?php

/**
 * Exceptions (pretty view)
 */

namespace Core;

use \Whoops\Run,
    \Whoops\Handler\PrettyPageHandler;


class Whoops
{

	/**
	 *
	 */
	public static function register()
	{
		$run     = new Run;
		$handler = new PrettyPageHandler;

		// Add a custom table to the layout:
		$handler->addDataTable('Сталася помилка!', array(
		));

		$run->pushHandler($handler);

		// Example: tag all frames inside a function with their function name
		$run->pushHandler(function($exception, $inspector, $run) {
			$inspector->getFrames()->map(function($frame) {
				if($function = $frame->getFunction()) {
					$frame->addComment("This frame is within function '$function'", 'cpt-obvious');
				}

				return $frame;
			});
		});

		$run->register();
	}
}
