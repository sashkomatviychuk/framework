<?php

error_reporting(E_ALL);

ini_set( 'display_errors',  'On');

define('ROOT',            "../");

define('MODULE_PATH',     '../application/modules/');

define('MODEL_PATH',      '../application/classes/Model/');

define('CONTROLLER_PATH', '../application/Controller/');

define('VIEWS_PATH',      '../application/system/views/');

define('PUBLIC_PATH',     '../public/');

define('DS', '/');

define('CONSOLE', true);

require_once '../application/config/path.php';
