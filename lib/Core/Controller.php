<?php

/**
 *
 */
namespace Core;

/**
 *
 */
use
	\ActiveRecord\Config      as DbConfig,
	\Core\Validate\Validation as Validation,
	\Core\Validate\Messages   as Messages,
	\Core\Http\Session        as Session;

/**
 *
 * Abstract class Controller
 *
 */
abstract class Controller
{
	/**
	 * variables
	 */

	public $_get = array();

	/**
	 *
	 */
	public $_post = array();

	/**
	 *
	 */
	public $_js = array();

	/**
	 *
	 */
	public $_css = array();

	/**
	 *
	 */
	public $db;

	/**
	 *
	 */
	public $_script;

	/**
	 *
	 */
	public $_build;

	/**
	 *
	 */
	public $_view;

	/**
	 *
	 */
	public $twig;

	/**
	 *
	 */
	public $_vars = array();

	/**
	 *
	 */
	public $lang;

	/**
	 * Initialization
	 */

	public function __construct()
	{
		#get params
		$this->_get = &$_GET;

		#post params
		$this->_post = &$_POST;

		#db builder class
		// $this->_build = new Db_Query;

		# db query class
		// \Db\Connection::init();
		// $this->db = \Db\Connection::get();

		#js
		$this->_script = new JS;

		# DB ActiveRecord
		$db = Config::get('database');

		$cfg = DbConfig::instance();
		$cfg->set_model_directory(APP_PATH . 'classes/Model');
		$cfg->set_connections(array('development' =>"mysql://{$db['user']}:{$db['pass']}@{$db['host']}/{$db['name']}"));

		// lang
		$this->lang = App::lang();
	}

	/**
	 * filters for actions
	 * ajaxOnly, getOnly, postOnly
	 */
	public function filter()
	{
		return array();
	}

	/**
	 * check, is request method GET
	 */
	public function isGET()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	/**
	 *
	 */
	public function isPOST()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	/**
	 *
	 */
	public function hasGET()
	{
		return (!empty($_GET));
	}

	/**
	 *
	 */
	public function hasPOST()
	{
		return (!empty($_POST));
	}

	/**
	 * @param $url string
	 * @param $params mixed
	 * @return redirect to link
	 * $this->redirect(<controller>/<action>, $params=array());
	 */
	public function redirectRoute($name, $params = array())
	{
		\Url::redirectRoute($name, $params);
	}

	/**
	 *
	 */
	public function redirectUrl($url)
	{
		\Url::redirectUrl($url);
	}

	/**
	 *
	 */
	public function refresh()
	{
		\Url::refresh();
	}

	/**
	 *
	 */
	public function before()
	{
		$logged = Session::get('_UID') && Session::get('_UID') !== 'guest';
		$this->_script->setVar('logged', $logged);
	}

	/**
	 *
	 */
	public function after()
	{
	}

	/**
	 *
	 */
	public function accessRules()
	{
		return array();
	}

	/**
	 * allowed action
	 *
	 * @param  $action string
	 * @return bool
	 */
	public function allowed($action)
	{
		$u_role = Session::get('_UID');
		$all_roles = $this->accessRules();
		$action = strtolower($action);

		foreach ($all_roles as $role => $actions) {
			if (in_array($action, $actions))
				return true;
			if ($role == $u_role)
				break;
		}

		return false;
	}

	/**
	 *
	 */
	public function isAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	/**
	 *
	 */
	public function call($class, $method, $params  = array())
	{
	}

	/**
	 *
	 */
	public function onError()
	{
	}

	/**
	 * load Model
	 */
	public function model($name)
	{
		$items = explode('\\', $name);
		foreach ($items as &$item) {
			$item = ucfirst(strtolower($item));
		}
		$name = '\Model\\' . implode('\\', $items);

		return new $name;
	}

	/**
	 * load module
	 */
	public function module($class)
	{
		$class = ucfirst($class);
		$class = "\Controller\\{$class}";
		return new $class;
	}

	/**
	 * load form
	 */
	public function form($class)
	{
		$class = ucfirst($class);
		$class = "\Form\\{$class}";
		return new $class;
	}

	/**
	 *
	 */
	public function setFilter()
	{
		$args = func_get_args();
		\Core\Call::factory()->methodArgs('\Core\Validate\Preprocess', 'setFilter', $args);
	}

	/**
	 *
	 */
	public function render($template, $args = array())
	{
		\View::assign('js', $this->_script->getAllVars());
		\View::assign('_', function ($text) { return __($text); });
		\View::assign('GET', $this->_get);
		\View::assign('POST', $this->_post);
		\View::assign('Config', \Config::instance());
		\View::assign('lang', \App::lang());
		\View::assign('ROUTER', \App::router());
		\View::assign('Message', \Message::instance());
		\View::assign('this', $this);

		return \View::make($template, $args);
	}

	/**
	 * render template
	 *
	 * @param string $template
	 * @param array  $args
	 * @return string
	 */
	public function renderPartial($template, $args = array())
	{
		\View::assign('_', function ($text) { return __($text); });
		return \View::render($template, $args);
	}

	/**
	 *
	 */
	public function assign($name, $val)
	{
		\View::assign($name, $val);
	}

	/**
	 *
	 */
	public function logged()
	{
		return Session::get('_UID') != 'guest';
	}

	/**
	 *
	 */
	public function createThumbs($file, $sizes = array())
	{
		\Utils\Thumbs::factory()->create($file, $sizes);
	}

	/**
	 *
	 */
	public function getThumbs($path, $filename, $sizes = array())
	{
		return \Utils\Thumbs::factory()->get($path, $filename, $sizes);
	}

	/**
	 * pagination
	 */
	public function pagination($limit = false)
	{
		$limit = $limit ? $limit : \Config::get('limit');

		if (isset($this->_get['page'])) {
			$page = $this->_get['page'];
		} else {
			$page = 1;
		}

		if ($page < 1)
			$page = 1;

		if ($page == 1)
			return array(0, $limit);

		$offset = ($page - 1) * $limit;

		return array($offset, $limit);
	}

	/**
	 *
	 */
	public function headers($headers = array())
	{
		foreach ($headers as $header) {
			header($header);
		}
	}

	/**
	 *
	 */
	public function token()
	{
		return \Core\Security::genateToken();
	}

}
