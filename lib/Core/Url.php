<?php

/**
 * @name: Url
 *
 */
namespace Core;

/**
 * Work with Url`s
 */
class Url
{

	/**
	 *
	 */
	public static function redirectRoute($name, $params = array())
	{
		$r = \Router::getByName($name);

		if (!empty($r)) {
			$url = $r['t'];
		} else {
			throw new \Exception("Router {$name} not found!", 500);
		}

		foreach ($params as $key => $val) {
			$url = str_replace("{{$key}}", $val, $url);
		}

		$url = trim($url, '/');
		$lang = \Core\App::lang();
		if (!empty($lang)) {
			$url = $lang . '/' . $url;
		}
		$url = "/{$url}";

		header('Location: '. $url);
		die;
	}

	/**
	 *
	 */
	public function redirectUrl($url)
	{
		header('Location: '. $url);
		die;
	}

	/**
	 *
	 */
	public static function refresh()
	{
		self::redirectUrl(\App::getUri());
	}

	/**
	 *
	 */
	public function create($route, $args = array(), $get = array())
	{
		$r = \Router::getByName($route);

		if (empty($r)) {
			return $r;
		}

		$url = $r['t'];

		foreach ($args as $key => $arg) {
			$url = str_replace("{{$key}}", $arg, $url);
			$url = str_replace("{?{$key}}", $arg, $url);
		}

		if (isset($r['bind'])) {
			$def =$r['bind'];
			foreach ($def as $key => $arg) {
				$url = str_replace("{{$key}}", $arg, $url);
				$url = str_replace("{?{$key}}", $arg, $url);
			}
		}

		$url = ltrim($url, '/');
		$lang = \App::lang();
		if (!empty($lang)) {
			$url = $lang . '/' . $url;
		}

		$url = rtrim($url, '/') . '/?';
		foreach ($get as $key => $param) {
			if (!empty($param)) {
				$url .= $key . '=' . $param . '&';
			}
		}

		$url = rtrim($url, '&');
		$url = rtrim($url, '?');

		return "/{$url}";
	}

	/**
	 *
	 */
	public static function current()
	{
		return \App::getUri();
	}

	/**
	 *
	 */
	public static function query()
	{
		$url = explode('?', \App::getUri());

		if (!isset($url[1]))
			return '';

		return $url[1];
	}
}
