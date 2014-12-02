<?php

/**
 *
 */
namespace Core\Http;

use \Core\Mca;

/**
 * Filtering actions
 */
class Filter
{
	/**
	 *
	 */
	public static $filters;

	/**
	 *
	 */
	public static $ip_filters = array();

	/**
	 *
	 */
	public function request($key, $filters)
	{
		$key = strtolower($key);
		self::$filters[$key] = $filters;
	}

	/**
	 *
	 */
	public function ip($key, $filters)
	{
		$key = strtolower($key);
		self::$ip_filters[$key] = $filters;
	}

	/**
	 * check filters
	 */
	public static function check($key)
	{
		$key = strtolower($key);
		$request = \App::request();

		if (!$key = Mca::get($key, array_keys(self::$filters)))
			return false;

		$filters = self::$filters[$key];

		if ($filters == '*')
			return true;

		if (!self::has($filters, $request['method']))
			return false;

		if ($request['xhr']) {
			if (!self::has($filters, 'ajax'))
				return false;
		}

		if (self::has($filters, 'token')) {

			if (!isset($_GET['token']))
				return false;

			if (!\Security::checkToken($_GET['token']))
				\Error::abort(400);
		}

		return true;
	}

	/**
	 *
	 */
	public static function has($filter, $key)
	{
		return preg_match("/(^{$key}|\|{$key}\||\|{$key}$)/", $filter);
	}

}
