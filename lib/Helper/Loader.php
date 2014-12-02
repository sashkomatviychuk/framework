<?php

/**
 *
 */
namespace Helper;

/**
 *
 */
class Loader
{
	/**
	 *
	 */
	public static $class_map = array();

	/**
	 *
	 */
	public static $dirs = array();

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
	 * aoutoloader
	 *
	 * @param  string $className
	 * @return void
	 */
	public function autoloader($className)
	{
		if ( class_exists($className) ) {
			return;
		}

		if ( isset(self::$class_map[$className]) ) {
			require_once self::$class_map[$className] . $this->prepare($className);
		} else {
			foreach ( self::$dirs as $dir ) {
				$dir = trim($dir, '/') . '/';
				$path = ROOT . $dir . $this->prepare($className);
				if ( file_exists( $path ) ) {
					require_once $path;
					break;
				}
			}
		}

	}

	/**
	 *
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'autoloader'));
	}

	/**
	 * add path
	 *
	 * @param  string $path
	 * @return
	 */
	public function path( $path )
	{
		self::$dirs[] = $path;
	}

	/**
	 *
	 * @param array $map
	 */
	public function classMap( $map = array() )
	{
		foreach ( $map as $key => $item ) {
			self::$class_map[$key] = $item;
		}
	}

	/**
	 * include file
	 *
	 * @param  string $path
	 */
	public function requirePath($path)
	{
		require_once ROOT . $path;
	}

	/**
	 *
	 */
	public function use_namespace($namespaces = array())
	{
		foreach ($namespaces as $alias => $namespace) {
			// use $namespace;
			class_alias($namespace, $alias, true);
		}
	}

	/**
	 * prepare class file path
	 *
	 * @param  string $className
	 * @return string
	 */
	public function prepare($className)
	{
		$className = str_replace('\\', '/', $className);
		$className = str_replace('//', '/', $className);
		$className = str_replace('_', '/', $className);

		return $className . '.php';
	}
}
