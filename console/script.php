<?php

	require_once 'bootstrap.php';

	/**
	 * parse arguments and run command
	 */
	// preprocess
	$pr   = new \Cli\Preprocess();
	//
	// $ds   = $pr->args('serve -za name=lolka v=kill');
	// $ds   = $pr->directives('serve -za name=lolka v=kill');
	// $ds   = $pr->commands('create module');
	// $tree = $pr->command_tree($line);
	//

	// create module name=test
	// 1) task -> create
	//
	// \Cli\Directives::process($ds);
	// list($command, $args) = $pr->parse($argv);
	//

	// run command
	//
	$cli = new \Cli\Command();
	// $cli->input_command();
	//

	// if ($cli->confirm('Error?')) {
	// 	echo "yes";
	// }
	// $cli->run($command, $args);
	// \Core\Call::factory()->x('\Cli\Command', $command, $args);

	// $str = 'name=Name arg1=A arg2=B';
	// $str = preg_replace('/\s{1,}/', '&', $str);
	// parse_str($str, $a);
	// echo($a); die;
	die;

	/**
	 * Create module
	 */
	// function module( $name )
	// {
	// 	$name = strtolower( $name );

	// 	if (!is_dir(MODULE_PATH . $name)) {
	// 		mkdir(MODULE_PATH . $name);
	// 	}

	// 	if (!is_dir(MODULE_PATH . $name . DS . 'Controller')) {
	// 		mkdir(MODULE_PATH . $name . DS . 'Controller');
	// 	}

	// 	if (!is_dir(MODULE_PATH . $name . DS . 'views')) {
	// 		mkdir(MODULE_PATH . $name . DS . 'views');
	// 	}

	// 	$layout = MODULE_PATH . $name . DS . 'views/layout.html';
	// 	$c_file = 'data/layout.txt';
	// 	$data   = file_get_contents($c_file);
	// 	$data   = str_replace('{v_path}', strtolower($layout), $data);

	// 	file_put_contents($layout, $data);
	// }

	// /**
	//  * create crud in module
	//  */
	// function crud( $name )
	// {
	// 	$view_files = array('list', 'view', 'create', 'update');
	// 	$args = explode( '/', $name );

	// 	if ( isset($args[0]) ) {
	// 		$module = MODULE_PATH . $args[0];
	// 	}

	// 	if ( isset($args[1]) ) {
	// 		$name = $args[1];
	// 	} else {
	// 		return false;
	// 	}

	// 	$c_file = 'data/controller.txt';
	// 	$data = file_get_contents($c_file);
	// 	$data = str_replace('{c_name}', ucfirst($name), $data);
	// 	$data = str_replace('{v_name}', strtolower($name), $data);

	// 	$file_path = $module . DS . 'Controller' . DS . ucfirst($name) . '.php';
	// 	file_put_contents($file_path, $data);

	// 	$v_file = 'data/view.txt';
	// 	$tmp_data = file_get_contents($v_file);

	// 	$view_dir = $module . DS . 'views' . DS . strtolower($name);
	// 	mkdir($view_dir);

	// 	foreach ( $view_files as $file ) {
	// 		$file_path = $view_dir . DS . $file . '.html';
	// 		$data = $tmp_data;
	// 		$data = str_replace('{v_name}', strtolower($args[0]), $data);
	// 		$data = str_replace('{v_path}', strtolower($file_path), $data);
	// 		file_put_contents( $file_path, $data );
	// 	}

	// }

	// /**
	//  * create controller
	//  */
	// function controller( $name )
	// {

	// }

	// /**
	//  * create module
	//  */
	// function model( $name, $table = null )
	// {
	// 	if ( is_null($table) ) {
	// 		$table = strtolower($name);
	// 	}

	// 	$parts = explode('_', $name);
	// 	$name = '';
	// 	foreach ( $parts as $one ) {
	// 		$name .= ucfirst($one);
	// 	}
	// }


	// /**
	//  * migration up
	//  */
	// function migration()
	// {

	// }

	// /**
	//  * create min css and js files
	//  */
	// function build($param = null)
	// {
	// 	$finds = array();
	// 	require_once('./jsmin.php');
	// 	require_once('./cssmin.php');

	// 	$css_dir = PUBLIC_PATH . 'css/*';
	// 	$js_dir  = PUBLIC_PATH . 'js/*';

	// 	$js_finds = array();
	// 	$css_finds = array();
	// 	process_css($css_dir, &$css_finds);
	// 	process_js($js_dir, &$js_finds);
	// 	$finds     = array_merge($css_finds, $js_finds);

	// 	process_views(VIEWS_PATH . '*', $finds);
	// }

	// function process_views($dir, $finds)
	// {
	// 	foreach (glob($dir) as $item) {
	// 		if (is_dir($item)) {
	// 			process_views($item. '/*');
	// 		} else {
	// 			echo 'process views file: ' . $item . PHP_EOL;
	// 			$data = file_get_contents($item);
	// 			foreach ($finds as $file => $new_file) {
	// 				$data = str_replace($file, $new_file, $data);
	// 			}
	// 			file_put_contents($item, $data);
	// 		}
	// 	}
	// }

	// function process_css($dir, $css_finds)
	// {
	// 	foreach (glob($dir) as $file) {
	// 		if (is_dir($file)) {
	// 			process_css($file . '/*', &$css_finds);
	// 		} else {
	// 			if (preg_match('/\.min\..*css/', $file)) {
	// 				continue;
	// 			}
	// 			// process minify file
	// 			echo 'process file: ' . $file . PHP_EOL;
	// 			$data = file_get_contents($file);
	// 			$new_file = preg_replace('/css$/', 'min.css', $file);
	// 			$data = CssMin::minify($data);
	// 			file_put_contents($new_file, $data);
	// 			$file         = '/public' . preg_replace('/.*\/public/', '', $file);
	// 			$new_file     = '/public' . preg_replace('/.*\/public/', '', $new_file);
	// 			$css_finds[$file] = $new_file;
	// 		}
	// 	}
	// }

	// function process_js($dir, $js_finds)
	// {
	// 	foreach (glob($dir) as $file) {
	// 		if (is_dir($file)) {
	// 			process_js($file . '/*', &$js_finds);
	// 		} else {
	// 			if (preg_match('/\.min\..*js/', $file)) {
	// 				continue;
	// 			}
	// 			// process minify file
	// 			echo 'process file: ' . $file . PHP_EOL;
	// 			$data = file_get_contents($file);
	// 			$new_file = preg_replace('/js$/', 'min.js', $file);
	// 			$data = JSMin::minify($data);
	// 			file_put_contents($new_file, $data);
	// 			$file         = '/public' . preg_replace('/.*\/public/', '', $file);
	// 			$new_file     = '/public' . preg_replace('/.*\/public/', '', $new_file);
	// 			$js_finds[$file] = $new_file;
	// 		}
	// 	}
	// }


	// if ( isset($argv[1]) ) {
	// 	$func = $argv[1];
	// }

	// if ( isset($argv[2]) ) {
	// 	$name = $argv[2];
	// }

	// if ( isset($func)
	// ) {
	// 	if ( function_exists($func) ) {
	// 		if (isset($name))
	// 			$func($name);
	// 		else
	// 			$func();
	// 		echo "created";
	// 	} else {
	// 		echo "Function {$func} does not exists!";
	// 	}
	// } else {
	// 	echo "Error! Check arguments";
	// }
