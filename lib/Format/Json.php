<?php

namespace Format;

/**
 *
 */
class Json
{
	/**
	 *
	 */
	public static function send($data = array())
	{
		self::contentHeader();
		self::encode($data);
		die;
	}

	/**
	 *
	 */
	public static function contentHeader()
	{
		header('Content-type: application/json');
	}

	/**
	 *
	 */
	public static function fileHeader($name)
	{
		$header = "Content-Disposition: attachment; filename={$name}.json";
		header($header);
	}

	/**
	 *
	 */
	public static function encode($data)
	{
		return json_encode($data);
	}

	/**
	 *
	 */
	public static function decode($data, $as_array = true)
	{
		return json_decode($data, $as_array);
	}

	/**
	 *
	 */
	public static function save($data, $filename)
	{
		self::contentHeader()
		self::fileHeader($filename);
		self::encode($data);
		die;
	}

	/**
	 *
	 */
	public static function load($filepath, $decode = false)
	{
		if (file_exists($filepath)) {
			$content = file_get_contents($filepath);

			if ($decode)
				return self::decode($content);

			return $content;
		}

		return false;
	}
}
