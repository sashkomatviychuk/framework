<?php

namespace Cli\Tasks;

/**
 *
 */
class Module
{
	/**
	 *
	 */
	public function __construct()
	{}

	/**
	 * Run module command
	 */
	public function create($name)
	{
		echo "creating module {$name} ..." . PHP_EOL;

		if (!is_dir(MODULE_PATH . $name)) {
			mkdir(MODULE_PATH . $name);
		}

		if (!is_dir(MODULE_PATH . $name . DS . 'Controller')) {
			mkdir(MODULE_PATH . $name . DS . 'Controller');
		}

		if (!is_dir(MODULE_PATH . $name . DS . 'views')) {
			mkdir(MODULE_PATH . $name . DS . 'views');
		}

		$layout = MODULE_PATH . $name . DS . 'views/layout.html';
		$c_file = 'data/layout.txt';
		$data   = file_get_contents($c_file);
		$data   = str_replace('{v_path}', strtolower($layout), $data);

		file_put_contents($layout, $data);

		echo 'done' . PHP_EOL;
	}

	/**
	 *
	 */
	public function delete($name)
	{
		echo "deleting module {$name} ..." . PHP_EOL;

		if (is_dir(MODULE_PATH . $name)) {
			self::_rrmdir(MODULE_PATH . $name);
		}

		echo 'done' . PHP_EOL;
	}

	/**
	 *
	 */
	protected static  function _rrmdir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") self::_rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
}
