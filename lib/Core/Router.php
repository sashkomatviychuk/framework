<?php

/**
 *
 */
namespace Core;

/**
 * Class for working with ROUTERS
 */
class Router
{
	#instance
	private static $_instance;

	/**
	 *
	 */
	public static $tmp;

	/**
	 *
	 */
	public static $params = array();

	#@array of routers
	private static  $_routers = array();

	#router tmp var

	private static $_router_tmp = array();

	# controller
	private static $_controller;

	# action
	private static  $_action;

	#router params
	private static $_params = array();

	/**
	 *
	 */
	public function __construct()
	{
	}

	/**
	 *
	 */
	public static function instance()
	{
		if(empty(self::$_instance))
			self::$_instance = new self();
		return self::$_instance ;
	}

	/**
	 * контроллер роутера
	 */
	public function controller()
	{
		return self::$_controller ;
	}
	/**
	 * екшн роутера
	 */
	public  function action()
	{
		return self::$_action ;
	}
	/**
	 * параметри роутера
	 */
	public  function params()
	{
		return self::$_params ;
	}

	/**
	 *
	 */
	public function normalizeUri($uri)
	{
		$uri = preg_replace('/[^a-z0-9\-\{\}\?\/]/', '', $uri);
		$uri = explode('/', $uri);

		foreach ($uri as &$item) {
			if (strpos($item, '}') > 0) {
				$item = preg_replace('/[^a-z0-9\{\}\?]/', '', $item);
			}
		}

		$uri = implode('/', $uri);
		$uri = preg_replace('/\?{2,}/', '?', $uri);
		$uri = rtrim($uri, '/') . '/';

		return $uri;
	}

	/**
	 *  Додати роутер
	 */

	public function set($name, $url)
	{
		$url = self::normalizeUri($url);
		self::$tmp = $name;
		self::$_router_tmp[$name]['t'] = $url;
		self::$_router_tmp[$name]['url'] = "~^{$url}$~";
		self::$_router_tmp[$name]['default'] = $url;

		return new self;
	}

	/**
	 *
	 */
	public function bind($key, $value)
	{
		self::$_router_tmp[self::$tmp]['bind'][$key] = $value;

		self::$_router_tmp[self::$tmp]['default'] = str_replace("{{$key}}", "{$value}", self::$_router_tmp[self::$tmp]['default']);

		self::$_router_tmp[self::$tmp]['default'] = str_replace("{?{$key}}", "{$value}", self::$_router_tmp[self::$tmp]['default']);

		return new self;
	}

	/**
	 *
	 */
	public function rule($key, $pattern)
	{
		// page/lang/
		// page/1/lang/
		// page/?(\d+)?/lang/
		self::$_router_tmp[self::$tmp]['url'] = str_replace("{{$key}}", "({$pattern})", self::$_router_tmp[self::$tmp]['url']);

		self::$_router_tmp[self::$tmp]['url'] = str_replace("/{?{$key}}", "/?({$pattern})?", self::$_router_tmp[self::$tmp]['url']);

		return new self;
	}

	/**
	 *
	 */
	public function module($name)
	{
		self::$_router_tmp[self::$tmp]['module'] = $name;
		return new self;
	}

	/**
	 *
	 */
	public function uses($function)
	{
		$f = explode('@', $function);

		if (count($f) != 2) {
			return false;
		}

		$c = $f[0];
		$a = $f[1];

		if (isset(self::$_router_tmp[self::$tmp]['default'])) {
			$router['default']    = self::$_router_tmp[self::$tmp]['default'];
		}

		if (isset(self::$_router_tmp[self::$tmp]['bind'])) {
			$router['bind']    = self::$_router_tmp[self::$tmp]['bind'];
		}

		if (isset(self::$_router_tmp[self::$tmp]['module'])) {
			$router['module'] = self::$_router_tmp[self::$tmp]['module'];
		} else {
			$router['module'] = '';
		}

		$router['url']    = self::$_router_tmp[self::$tmp]['url'];
		$router['t']      = self::$_router_tmp[self::$tmp]['t'];
		$router['class']  = $c;
		$router['method'] = $a;

		self::$_routers[self::$tmp] = $router;
	}

	/**
	 *
	 */
	public function getByName($name)
	{
		if (!isset(self::$_routers[$name])) {
			return '';
		}

		return self::$_routers[$name];
	}

	/**
	 * Вибираємо роутер за заданим URI
	 * @param string $URI
	 * @return array
	 */
	public static function get($uri)
	{
		#preparing
		$routes = self::$_routers ;
		$uri = self::getClearUrl($uri);
		$uri = rtrim(preg_replace('~^/?\w+/~', '', $uri), '/') . '/';

		#search router
		foreach ($routes as $name => $route) {
			$pattern = $route['url'];

			if(preg_match($pattern, $uri, $tmp_params)) {
				if (!$route['module'])
					$route['module'] = Config::get('default.module');

				array_shift($tmp_params);
				preg_match('~\{(\w+)\}~', $route['default'], $matches);
				array_shift($matches);

				$params = array();
				foreach ($matches as $key => $match) {
					$params[$match] = $tmp_params[$key];
				}

				return array(
					'controller' => "\\{$route['module']}\\Controller\\". ucfirst($route['class']),
					'action' => 'action' . ucfirst($route['method']),
					'module' => $route['module'],
					'params' => $params,
					'lang'   => \Core\Http\Session::get('_lang'),
					'name'   => $name
				);
			}
		}

		return false;
	}

	/**
	 *
	 */
	public function getClearUrl($base)
	{
		return preg_replace('/\?(.*)$/', '', $base);
	}

}
