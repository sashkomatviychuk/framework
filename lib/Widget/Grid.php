<?php

namespace Widget;

/**
 *
 */
class Grid
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
		$labels = $form->labels();

		echo \View::render('_sys_widgets/grid', array('grid' => $form->grid(), 'labels' => $labels));
	}
}
