<?php

/**
 *
 */
namespace Core;


use \Core\Http\Session as Session;

/**
 * Extend Standart Twig Functions
 */
class TwigFuncs
{
	/**
	 * create URL from router
	 */
	public static function url()
	{
		return new \Twig_SimpleFunction('url', function ($route, $args = array(), $token = false) {
			if ($token) {
				$token = \Security::genateToken();
			}

			return \Url::create($route, $args, array('token' => $token));
		});
	}

	/**
	 * logout
	 */
	public static function logout()
	{
		return new \Twig_SimpleFunction('logout', function () {
			$url = \Url::create('logout');
			$url = rtrim($url, '/') . '/?r=' . $_SERVER['REQUEST_URI'];
			return $url;
		});
	}

	public static function logged()
	{
		return new \Twig_SimpleFunction('logged', function () {
		    return Session::get('_UID') != 'guest';
		});
	}

	/**
	 *
	 */
	public static function persist()
	{
		return new \Twig_SimpleFunction('persist', function () {
		    require_once COMP_PATH . 'HTML/FormPersister.php';
			ob_start(array('HTML_FormPersister', 'ob_formpersisterhandler'));
		});
	}

	/**
	 *
	 */
	public static function end_persist()
	{
		return new \Twig_SimpleFunction('end_persist', function () {
			ob_get_flush();
		});
	}

	/**
	 *
	 */
	public static function widget()
	{
		return new \Twig_SimpleFunction('widget', function () {

			$args = func_get_args();

			if ( count($args) == 0) {
				return false;
			}

			$name = $args[0];
			unset($args[0]);

			if ( count($args) == 0 ) {
				$args = array();
			}

			\Core\Call::factory()->methodArgs("\\Widget\\{$name}", 'run', $args);
		});
	}

	/**
	 * translate function
	 */
	public static function translate()
	{
		return new \Twig_SimpleFunction('t', function ($key) {
			echo I18n::factory()->t($key);
		});
	}

	/**
	 *
	 */
	public static function messages()
	{
		return new \Twig_SimpleFunction('messages', function () {
			// return Message::pop();
		});
	}

	/**
	 *
	 */
	public static function has_messages()
	{
		return new \Twig_SimpleFunction('has_messages', function () {
			return Message::has();
		});
	}


	/**
	 *
	 */
	public static function token()
	{
		return new \Twig_SimpleFunction('token', function () {
			return \Core\Security::genateToken();
		});
	}

	/**
	 *
	 */
	public static function dump()
	{
		return new \Twig_SimpleFunction('dump', function ($var) {
			var_dump($var);
		});
	}

	/**
	 *
	 */
	public static function captcha()
	{
		return new \Twig_SimpleFunction('captcha', function () {
			\Core\Captcha::factory()->create();
		});
	}

	/**
	 *
	 */
	public static function username()
	{
		return new \Twig_SimpleFunction('username', function () {
			return 'User';
		});
	}

	/**
	 *
	 */
	public static function allow()
	{
		return new \Twig_SimpleFunction('allow', function ($key) {
			return \Core\Access::check($key);
		});
	}

	/**
	 *
	 */
	public static function lang()
	{
		return new \Twig_SimpleFunction('lang', function () {
			return \App::lang();
		});
	}

	/**
	 *
	 */
	public static function notEmpty()
	{
		return new \Twig_SimpleFunction('notEmpty', function ($value) {
			return !empty($value);
		});
	}

}
