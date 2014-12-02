<?php

/**
 * Cli preprocess
 */
namespace Cli;

/**
 *
 */
class Preprocess
{
	/**
	 *
	 */
	public $command;

	/**
	 *
	 */
	public $arguments = array();

	/**
	 *
	 */
	public function __construct() {}

	/**
	 *
	 */
	public function parse($args = array())
	{
		array_shift($args);

		if ( !isset($args[0]) ) {
			echo 'Invalid command' . PHP_EOL;
			return false;
		}

		$this->command = $args[0];
		unset($args[0]);

		foreach ( $args as $arg ) {
			$this->arguments[] = $arg;
		}

		return array($this->command, $this->arguments);
	}

	/**
	 *
	 */
	public function directives($line)
	{
		$line = preg_replace('/[^\-]\w{2,}/', '', $line);
		$line = preg_replace('/[^\-]\w\s/', '', $line);
		$line = preg_replace('/\s+/', ' ', $line);

		return explode(' ', $line);
	}

	/**
	 *
	 */
	public function args($line)
	{
		$args = explode(' ', $line);
		foreach ($args as $k => $arg) {
			$args[$k] = preg_replace('/^\w+$/', '', $args[$k]);
			if (strpos($args[$k], '=') == false) {
				unset($args[$k]);
			}
		}

		$str = implode(' ', $args);
		$str = preg_replace('/\s{1,}/', '&', $str);

		parse_str($str, $t_args);

		return $t_args;
	}

	/**
	 *
	 */
	public function normalize($line)
	{
		$line = trim($line);
		$line = preg_replace('/\s+/', ' ', $line);

		return $line;
	}
}
