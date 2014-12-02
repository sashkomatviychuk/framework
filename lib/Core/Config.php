<?php

/**
 *
 */
namespace Core;

/**
 * Configs class
 */
class Config
{
	/**
	 *
	 */
	private static $_configs = array();

	/**
	 *
	 */
	public static function init($configs)
	{
		if (is_array($configs))
			self::$_configs = $configs;
	}

	/**
	 *
	 */
	public static function instance()
	{
		return new self;
	}

	/**
	 *
	 */
	public static function get($key)
	{
		if ( isset(self::$_configs[$key])) {
			return self::$_configs[$key];
		}

		return false;
	}

	/**
	 *
	 */
	public static function set($key, $val)
	{
		self::$_configs[$key] = $val;
	}

	/**
	 *
	 */
	public static function all()
	{
		return self::$_configs;
	}

	/**
	 *
	 */
	public static function load($file)
	{
		self::$_configs = parse_ini_file($file, true);
	}

	/**
	 *
	 */
	public static function ini_set($key, $value)
	{
		ini_set($key, $value);
	}

	/**
	 *
	 */
	public static function ini_get($key)
	{
		return ini_get($key);
	}

	/**
	 *
	 */
	public static function ini_get_all()
	{
		return ini_get_all();
	}
}
