<?php

namespace site\Controller;

/**
 *
 */
use \Core\Controller         as Controller;


/**
 *
 */
class Posts extends Controller
{

	public function before()
	{
		parent::before();
	}

	/**
	 *
	 */
	public function actionIndex()
	{
		$this->render('test');
	}

}

