<?php

/**
 *
 */
namespace Core;
/**
 * Basic application class
 * Author: Matviychuk Alex
 * year: 2013
 */
class Core
{

	public function __construct()
	{
	}


	public static function runAction($controller, $action, $params = array(), $module = '')
	{
		// build access key
		$mcaKey = '';
		//if isset module
		if (!empty($module)) {
			$mcaKey = strtolower($module) . ".";
		}

		// prepare access key
		$act = strtolower(preg_replace('/^action/', '', $action));
		$ctr = strtolower(preg_replace('/(.+)?[^\w+$]/', '', $controller));
		$mcaKey .= "{$ctr}.{$act}";
		// Filter request
		Http\Filter::check($mcaKey) || Error::abort('400');

		// Check access rules
		$allowed = Access::check($mcaKey);

		// redirect, if not auth
		$url = \Url::create('login');
		$url = rtrim($url, '/') . '/?r=' . $_SERVER['REQUEST_URI'];
		$allowed || \Url::redirectUrl($url);

		// Run action
		Call::factory()->method($controller, 'before');
		Call::factory()->methodArgs($controller, $action, $params);
		Call::factory()->method($controller, 'after');
	}

	public static function normalizeUrl($url = array())
	{
		$link = '/';
		foreach ($url as &$value) {
			if (!empty($value))
				$link .= $value . '/';
		}
		return $link;
	}

	public static function getIndexUrl()
	{
		$link = Config::get('default');
		return self::normalizeUrl($link);
	}

	public static function loadClass($class)
	{
		return new $class;
	}

	public static function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
}

?>
