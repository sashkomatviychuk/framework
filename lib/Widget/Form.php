<?php

namespace Widget;

/**
 *
 */
class Form
{
	/**
	 *
	 */
	public static function run()
	{
		$args  =  func_get_args();

		if (count($args) == 0) {
			return false;
		}

		$form = '\Form\\' . $args[0];
		$form = new $form;

		echo $form->generate();
	}
}
