<?php

/**
 * command line interface
 */
// Command examples:
// php organizer create module name=A
// php organizer delete module name
// php organizer exec "command"
// php organizer start migration
// php organizer start build

namespace Cli;

/**
 *
 */
class Command
{
	/**
	 *
	 */
	public $color;

	/**
	 *
	 */
	public function __construct() {
		$this->color = new \Cli\Colors();
	}

	/**
	 *
	 */
	public function run($command, $args = array())
	{
		if (empty($args)) {
			echo 'fail arguments';
			return false;
		}

		$task = reset($args);
		$task = ucfirst(strtolower($task));
		$task = "\Cli\Tasks\\" . $task;

		$command = strtolower($command);

		$str = implode(' ', $args);
		$str = preg_replace('/\s{1,}/', '&', $str);
		parse_str($str, $tmp_args);

		$args = array();
		if (isset($tmp_args['name']))
			$args['name'] = $tmp_args['name'];

		\Core\Call::factory()->x($task, $command, $args);
	}

	/**
	 *
	 */
	public function confirm($question = '')
	{
		if (!$question)
			return false;

		$answer = '';
		$question = rtrim($question, '?') . '?';
		$question .= "[y/n]:";
		while ($answer != 'y' || $answer != 'n') {
			echo $question;
			$answer = stream_get_line(STDIN, 1024, PHP_EOL);
			$answer = strtolower($answer);
			if ($answer == 'y' || $answer == 'n') {
				break;
			}
		}

		return $answer == 'y';
	}

	/**
	 *
	 */
	public function input_command()
	{
		$command =  stream_get_line(STDIN, 1024, PHP_EOL);
	}

	/**
	 *
	 */
	public function info($text)
	{
		// echo $this->color->getColoredString($text, 'cyan');
		echo "Info: {$text}\n";
	}

	/**
	 *
	 */
	public function warning($text)
	{
		// echo $this->color->getColoredString($text, 'red');
		echo "Warning: {$text}\n";
	}

	/**
	 *
	 */
	public function success($text)
	{
		// echo $this->color->getColoredString($text, 'green');
		echo "Success: {$text}\n";
	}

	/**
	 *
	 */
	public function exec($string)
	{
		exec($string);
	}

	/**
	 *
	 */
	public function system($string)
	{
		system($string);
	}

}
