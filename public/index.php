<?php
#error reporting
error_reporting(E_ALL & ~E_STRICT);

# base path
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/");

#system defines
define('DS', '/');
define('SYS_PATH',    ROOT . 'application/system/');
define('APP_PATH',    ROOT . 'application/');
define('CORE_PATH',   ROOT . 'lib/');
define('COMP_PATH',   ROOT . 'components/');
define('PUBLIC_PATH', ROOT . 'public/');
define('CACHE_PATH',  ROOT . 'application/system/cache');
define('MODULE_PATH', ROOT . 'application/modules/');
define('LANGS_PATH',  ROOT . 'application/system/i18n/');
define('VIEWS_PATH',  ROOT . 'view/themes');
define('EXT', '.php');

defined('DEBUG_MODE') || define('DEBUG_MODE', true);

# init autoloader
require_once COMP_PATH . 'composer/autoload.php';
require_once APP_PATH . 'config/path.php';

# init timezone
ini_set('date.timezone', 'Europe/Kiev');

# create logs
ini_set('error_log', SYS_PATH . 'logs' . DS . 'error_' .date("Y_m_d-H_i_s") . '.log');

# errors logs
DEBUG_MODE || ini_set( 'log_errors', 'On' );
DEBUG_MODE || ini_set( 'display_errors',  'Off');

DEBUG_MODE && ini_set( 'log_errors', 'Off' );
DEBUG_MODE && ini_set( 'display_errors',  'On');

# get routers
require_once APP_PATH . 'config/routers.php';
# get configs
require_once APP_PATH . 'config/configs.php';

require_once APP_PATH . 'config/access.php';

require_once APP_PATH . 'config/filters.php';

# exceptions
DEBUG_MODE && \Core\Whoops::register();

# start session
\Session::start();

# run application
\App::run();
