<?php

namespace site\Controller;

/**
 *
 */
use \Model\Users     as Users,
	\Core\Controller as Controller;

/**
 *
 */
class Index extends Controller
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

	/**
	 *
	 */
	public function actionCaptcha()
	{
		\Captcha::factory()->create();
	}

	/**
	 *
	 */
	public function actionCheck()
	{
		$captchaValidator = new \Validator(\Rule::captcha());

		if ($captchaValidator->validate($_GET['code'])) {
			echo 'valid';
		} else {
			echo 'not valid';
		}
	}

}

