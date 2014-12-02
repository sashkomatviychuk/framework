<?php

/**
 *
 */
namespace Core;

/**
 *
 */
class Access
{
	public function __construct()
	{}

	/**
	 *
	 */
	protected static $rules = array();

	/**
	 *
	 */
	public function set($key, $rules = array())
	{
		$key = strtolower($key);
		self::$rules[$key] = $rules;
	}

	/**
	 *
	 */
	public function check($key)
	{
		if (!$key = Mca::get(strtolower($key), array_keys(self::$rules)))
			return false;

		$role = \Session::get('_UID');

		return preg_match("/(^{$role}|\|{$role}\||\|{$role}$)/", self::$rules[$key]);
	}
}
