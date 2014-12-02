<?php

namespace Core;

/**
 *
 */
class Input
{
	/**
	 *
	 */
	static $active_array; // get post action

	/**
	 *
	 */
	public static function get($key = false, $value = false)
	{
		if (!$key && !$value)
			return $_GET;

		if ($key && !$value) {
			if (isset($_GET[$key]))
				return $_GET[$key];

			return false;
		}

		$_GET[$key] = $value;
	}

	/**
	 *
	 */
	public static function post($key = false, $value = false)
	{
		if (!$key && !$value)
			return $_POST;

		if ($key && !$value) {
			if (isset($_POST[$key]))
				return $_POST[$key];

			return false;
		}

		$_POST[$key] = $value;
	}

	/**
	 *
	 */
	public static function action($key = false)
	{
		$params = \App::getCurrParams();

		if (!$key)
			return $params;

		if (isset($params[$key]))
			return $params[$key];

		return false;
	}

	/**
	 *
	 */
	public static function notEmpty($key)
	{
		$key = strtolower($key);

		if ($key == 'get') {
			return !empty($_GET);
		} elseif ($key == 'post') {
			return !empty($_POST);
		} elseif ($key == 'action') {
			$params = \App::getCurrParams();
			return !empty($params);
		}

		return false;
	}
}
