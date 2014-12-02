<?php

namespace Core;

/**
 * Module - controller - action
 */
class Mca
{
	/**
	 *
	 */
	static $keys_templates = array(
		'{m}.{c}.{a}',
		'{m}.{c}.*',
		'{m}.*.{a}',
		'{m}.*',
		'*.{c}.{a}',
		'*.{c}.*',
		'*.{a}',
		'*',
	);

	/**
	 *
	 */
	static $module_template = '{m}';

	/**
	 *
	 */
	static $controller_template = '{c}';

	/**
	 *
	 */
	static $action_template = '{a}';

	/**
	 *
	 */
	static $all_template = '*';

	/**
	 *
	 */
	public static function get($key, $rules)
	{
		$keys = self::modifyKey($key);

		foreach ($keys as $key) {
			if (in_array($key, $rules)) {
				return $key;
			}
		}

		return false;
	}

	/**
	 *
	 */
	public static function modifyKey($key)
	{
		$parts = explode('.', $key);

		if (count($parts) != 3) {
			throw new Exception("Not valid access key structure", 1);
		}

		list($m, $c, $a) = $parts;

		$keys = array();
		foreach (self::$keys_templates as $tmp) {
			$tmp = str_replace("{m}", $m, $tmp);
			$tmp = str_replace("{c}", $c, $tmp);
			$tmp = str_replace("{a}", $a, $tmp);
			$keys[] = $tmp;
		}

		return $keys;
	}

}
