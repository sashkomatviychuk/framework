<?php

/**
 *
 */
namespace Core;

/**
 *
 */
use \Core\Http\Session as Session,
	\Core\Http\Filter  as Filter;

/**
 * Application class
 * Create application
 * Run application
 */
class App
{

	#self router
	private static $_router;

	#self controller
	private static $_controller;

	#self action
	private static $_action;

	#self params
	private static $_params;

	# current router name
	public static $route = array();

	# module
	public static $module = '';

	/**
	 *
	 */
	public static $mca;

	/**
	 * @return Session _UID var
	 */
	public static function getUserStatus()
	{
		return strtolower(Session::get('_UID'));
	}

	/**
	 *
	 */
	public static function load()
	{
		return self;
	}

	/**
	 *
	 */
	public static function router()
	{
		return self::$route;
	}

	/**
	 * Поточний роутер
	 */
	public static function getRoute()
	{
		return self::$route['name'];
	}

	/**
	 * Поточний контроллер
	 */
	public static function getCurrController()
	{
		return self::$route['controller'];
	}

	/**
	 * Поточний екшн
	 */
	public static function getCurrAction()
	{
		return self::$route['action'];
	}

	/**
	 * Поточні параметри
	 */
	public static function getCurrParams()
	{
		return self::$route['params'];
	}

	/**
	 *
	 */
	public static function lang()
	{
		if (isset(self::$route['lang']))
			return self::$route['lang'];
		return Config::get('lang.default');
	}

	/**
	 * Поточний URI
	 */
	public static function getUri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * Браузер користувача
	 */
	public static function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}

	/**
	 * IP користувача
	 */
	public static function getUserIp()
	{
		return $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * GET параметри
	 */
	public static function getQueryString()
	{
		return $_SERVER['QUERY_STRING'];
	}

	/**
	 *
	 */
	public static function hasQueryString()
	{
		return (!empty($_SERVER['QUERY_STRING']));
	}

	/**
	 *
	 */
	public static function setRoute( $route )
	{
		self::$route = $route;
	}

	/**
	 *
	 */
	public static function setModule($module)
	{
		self::$module = $module;
	}

	/**
	 *
	 */
	public static function getModule()
	{
		return self::$module;
	}

	/**
	 * Application execute
	 */
	public static function run()
	{
		if (isset($_SERVER['REDIRECT_URL']))
			$url = $_SERVER['REDIRECT_URL'];
		else
			$url = $_SERVER['REQUEST_URI'];

		if (preg_match('/^\/[a-z]{2}\//', $url) == 0) {
			$lang = Config::get('lang.default');
			if (Config::get('lang.enable')) {
				$url = preg_replace('/^\//', "/{$lang}/", $url);
				Url::redirectUrl(rtrim($url, '/') . '/');
			}
		}

		preg_match('/^\/[a-z]{2}/', $url, $match);
		$lang = trim($match[0], '/');
		$langs = Config::get('langs');

		if (!in_array($lang, $langs)) {
			$lang = Config::get('lang.default');
			if (Config::get('lang.enable')) {
				$url = preg_replace('/^\/[a-z]+\//', "/{$lang}/", $url);
				Url::redirectUrl(rtrim($url, '/') . '/');
			}
		}

		require_once APP_PATH . 'config/l10n.php';

		Session::set('_lang', $lang);

		$uid = Session::get('_UID');
		$uid || Session::set('_UID', 'guest');

		if (!$route = \Router::get($url)) {
			\Error::abort('404');
		}

		self::setRoute($route);

		#create controller
		if (!class_exists($route['controller'])) {
			\Error::abort('404');
		}

		$controller = $route['controller'];
		$action = $route['action'];
		$params = $route['params'];
		$module = $route['module'];

		#run application, if action exist
		if (!method_exists($controller, $action)) {
			Error::abort('404');
		}

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
		Config::set('modules.views.dir', APP_PATH . 'modules/' . $module . '/views');

		self::$mca = $mcaKey;
		// Filter request
		Http\Filter::check($mcaKey) || Error::abort('400');

		// Check access rules
		$allowed = Access::check($mcaKey);

		// redirect, if not auth
		$url = Url::create('login');
		$url = rtrim($url, '/') . '/?r=' . $_SERVER['REQUEST_URI'];
		$allowed || \Session::get('_UID') == 'guest' && Url::redirectUrl($url);

		$allowed || \Session::get('_UID') != 'guest' && \Error::abort('403');

		// Run action
		Call::factory()->method($controller, 'before');
		Call::factory()->methodArgs($controller, $action, $params);
		Call::factory()->method($controller, 'after');
	}

	/**
	 *
	 */
	public static function request()
	{
		$data = array();
		$data['mca'] = self::$mca;
		$data['method'] = strtolower($_SERVER['REQUEST_METHOD']);
		$data['xhr'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

		return $data;
	}
}
