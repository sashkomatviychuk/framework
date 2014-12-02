<?php

/**
 * Call functions, class methods
 */
namespace Core;

/**
 *
 */
class Call
{
	/**
	 *
	 */
	public static $instance;

	/**
	 *
	 */
	public static function factory()
	{
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	/**
	 *
	 */
	public function __construct() {}

	/**
	 * call method with params
	 *
	 * @param  string $class
	 * @param  string $method
	 * @param  array $params
	 * @return function
	 */
	public function methodArgs( $class, $method, $params = array())
	{
		$c = new $class;
		$method = new \ReflectionMethod($class, $method);
		return $method->invokeArgs($c, $params);
	}

	/**
	 * call method without params
	 *
	 * @param  string $class
	 * @param  string $method
	 * @return function
	 */
	public function method( $class, $method )
	{
		$c = new $class;
		$method = new \ReflectionMethod($class, $method);
		return $method->invokeArgs($c, array());
	}

	/**
	 * call new class
	 *
	 * @param  string $class
	 * @return instance
	 */
	public function loadClass($class)
	{
		if ( !$this->issetClass($class) ) {
			return false;
		}

		return new $class;
	}

	/**
	 * class exist
	 *
	 * @param  string $class
	 * @return bool
	 */
	public function issetClass($class)
	{
		return class_exists($class);
	}

	/**
	 * @param  string $class
	 * @param  string $method
	 * @param  array $params
	 * @return function
	 */
	public function x($class, $method, $params = array())
	{
		return call_user_func_array(array($class, $method), $params);
	}
}
