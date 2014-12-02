<?php

/**
 *
 */

namespace Cli;

/**
 *
 */
class Directives
{
	/**
	 *
	 */
	public static $keys = array(
		'-v' => 'version',
		'-i' => 'info',
		'-h' => 'help'
	);

	/**
	 *
	 */
	public static function method($key)
	{
		if (!isset(self::$keys[$key]))
			return false;

		return self::$keys[$key];
	}

	/**
	 *
	 */
	public static function version()
	{
		echo "Console version: 0.0.1 \n";
		return false;
	}

	/**
	 *
	 */
	public static function info()
	{
		echo "Info: PHP MVC Framework, 2013-2014 \n";
		return false;
	}

	/**
	 *
	 */
	public static function help()
	{
		echo "Console commands:\n";
		echo "\tcreate module name=[name], name - inputed value\n";
		echo "\tdelete module name=[name], name - inputed value\n";
		echo "\tcreate model name=[name], name - inputed value\n";
		echo "\tdelete model name=[name], name - inputed value\n";
		echo "\tcreate crud name=[name], name - inputed value\n";
		echo "\tdelete crud name=[name], name - inputed value\n";
		return false;
	}

	/**
	 *
	 */
	public static function process(array $ds)
	{
		foreach ($ds as $d) {
			$method = self::method($d);

			if (method_exists('\Cli\Directives', $method))
				self::$method();
		}
	}
}
