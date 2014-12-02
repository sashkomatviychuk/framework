<?php

\Config::set('database', array(
		'host'=>'localhost',
		'name'=>'test',
		'user'=>'root',
		'pass'=>'root'
	));

\Config::set('default', array(
		'controller' => 'index',
		'action'     => 'index'
	));

\Config::set('views', 'view/themes/default/');

\Config::set('homePage', '/');

\Config::set('public', array(
		'css'     => '/public/css/',
		'js'      => '/public/js/',
		'images'  => '/public/img/',
		'uploads' => '/public/uploads/',
	));

\Config::set('title', 'MyApplication');

// langs configs
\Config::set('lang.enable', true);
\Config::set('lang.default', 'uk');

// cache configs
\Config::set('use.cache', true);
\Config::set('cache.life', 300);

// paginator
\Config::set('limit', 10);

// twig
\Config::set('twig.cache.dir', \Config::get('use.cache') ? CACHE_PATH : false);

\Config::set('views.dir', APP_PATH . 'system/views');
\Config::set('forms.view.dir', APP_PATH . 'system/views/form');
\Config::set('errors.view.dir', APP_PATH .'system/views/errors');

// other
\Config::set('modules.view.dir', MODULE_PATH );

\Config::set('theme', 'default');

\Config::set('views.ext', '.html');

\Config::set('images.driver', 'gd'); // gd, imagick

\Config::set('thumbs', array(
	'100x100', '300x300'
));

\Config::set('langs', array('uk', 'ru', 'en'));
\Config::set('langs.translation', array(
	'uk' => 'Українська',
	'ru' => 'Русский',
	'en' => 'English'
));

\Config::set('default.module', 'site');
