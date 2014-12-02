<?php

/**
 *
 */
namespace Core\Http;

/**
 *
 */
class Session
{
	/**
	 *
	 */
	private static $_data = array();

	/**
	 *
	 */
	public function Session()
	{
		self::$_data = $_SESSION;
	}

	/**
	 *
	 */
	public static function start()
	{
		@session_start();
	}

	/**
	 *
	 */
	public static function isStarted()
	{
		return session_id() !== '';
	}

	/**
	 *
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 *
	 */
	public static function bind($key, &$value)
	{
		$_SESSION[$key] = &$value;
	}

	/**
	 *
	 */
	public static function get($key)
	{
		if (isset($_SESSION[$key]))
			return $_SESSION[$key];
		return false;
	}

	/**
	 *
	 */
	public static function destroy()
	{
		if (session_id() !== '')
			@session_destroy();
	}

	/**
	 *
	 */
	public static function close()
	{
		if (session_id() !== '')
			@session_write_close();
	}

	/**
	 *
	 */
	public static function deleteVar($key)
	{
		session_unregister($key);
	}

	/**
	 *
	 */
	public static function getId()
	{
		return @session_id();
	}

	/**
	 *
	 */
	public static function getKeys()
	{
		return array_keys($_SESSION);
	}

	/**
	 *
	 */
	public static function getAll()
	{
		return $_SESSION;
	}

	/**
	 *
	 */
	public static function replace($session)
	{
		$_SESSION = $session;
	}

}
