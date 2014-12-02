<?php

// regiser autoloader
if (defined('CONSOLE')) {
	require_once '../lib/Helper/Loader.php';
} else {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/Helper/Loader.php';
}

$loader = new Helper\Loader();

// Include pathes
$loader->path('application/classes');
$loader->path('application/modules');
$loader->path('lib');
$loader->path('components');
$loader->path('components/migrations');

// Include files
// $loader->requirePath('components/Db/ActiveRecord.php');

// Include Classes
$loader->classMap(
				array(
					'\Whoops\Util\TemplateHelper' => 'components/Whoops/Util/TemplateHelper.php',
					'\Requests' => 'components/Http/Requests.php'
				)
			);

// register
$loader->register();

$loader->use_namespace(array(
				'Validator'   => '\Core\Validate\Validator',
				'Rule'        => '\Core\Validate\Rule',
				'Pagination'  => '\Core\Pagination',
				'Session'     => '\Core\Http\Session',
				'Filter'      => '\Core\Http\Filter',
				'Access'      => '\Core\Access',
				'Security'    => '\Core\Security',
				'Message'     => '\Core\Message',
				'File'        => '\Core\File',
				'Auth'        => '\Core\Auth',
				'Config'      => '\Core\Config',
				'Error'       => '\Core\Error',
				'Router'      => '\Core\Router',
				'App'         => '\Core\App',
				'Model'       => '\Core\Model',
				'Captcha'     => '\Core\Captcha',
				'Input'       => '\Core\Input',
				'View'        => '\Core\View',
				'I18n'        => '\Core\I18n',
				'FormBuilder' => '\Core\FormBuilder',
				'Url'         => '\Core\Url',
			)
		);
