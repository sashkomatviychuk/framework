<?php

/**
 *
 */
namespace Core;

/**
* Display templates =)
*/
class View
{
	/**
	 *
	 */
	public static $vars;

	/**
	 *
	 */
	public static $twig;

	/**
	 *
	 */
	public static $smarty;

	/**
	 *
	 */
	public static function init()
	{
		if (!self::$smarty) {
			self::$smarty = new \Smarty();
			// self::$smarty->caching = true;
			self::$smarty->setCompileDir(SYS_PATH . 'smarty/templates_c');
			self::$smarty->setConfigDir(SYS_PATH . 'smarty/configs');
			self::$smarty->setCacheDir(SYS_PATH . 'smarty/cache');

			self::$smarty->setPluginsDir(array('./plugins', SYS_PATH . 'smarty/plugins'));
			// system views
			self::$smarty->setTemplateDir(Config::get('views.dir'));

			// module views
			if (Config::get('modules.views.dir'))
				self::$smarty->addTemplateDir(Config::get('modules.views.dir'), 'module');
		}
	}

	/**
	 *
	 */
	public static function render($template, $vars = array())
	{
		self::init();

		self::$smarty->assign($vars);

		return self::$smarty->fetch($template . \Config::get('views.ext'));
	}

	/**
	 *
	 */
	public static function make($template, $vars = array())
	{
		self::init();

		self::$smarty->assign($vars);

		echo self::$smarty->fetch($template . \Config::get('views.ext'), \App::lang());
	}

	/**
	 *
	 */
	public static function assign($key, $value, $nocache = false)
	{
		self::init();
		self::$smarty->assign($key, $value, true);
	}

}

