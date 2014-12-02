<?php

	namespace Core;

	/**
	 * View custom errors
	 */
	class Error
	{
		public static $_ERROR = array(
			'400' => array(
				'http' => 'HTTP/1.0 400 Bad Request',
				'status' => 'Status: 400 Bad Request',
				'layout' => '400'
			),
			'401' => array(
				'http' => 'HTTP/1.0 401 Unauthorized',
				'status' => 'Status: 401 Unauthorized',
				'layout' => '401'
			),
			'403' => array(
				'http' => 'HTTP/1.0 403 Forbidden',
				'status' => 'Status: 403 Forbidden',
				'layout' => '403'
			),
			'404' => array(
				'http' => 'HTTP/1.0 404 Not Found',
				'status' => 'Status: 404 Not Found',
				'layout' => '404'
			),
			'301' => array(
				'http' => 'HTTP/1.0 403 Moved Permanently',
				'status' => 'Status: 403 Moved Permanently',
				'layout' => '301'
			),
			'500' => array(
				'http' => 'HTTP/1.0 500 Internal Server Error',
				'status' => 'Status: 500 Internal Server Error',
				'layout' => '500'
			)
		);
		/**
		 *
		 */
		public static $layout = 'error';

		public static $twig;

		/**
		 *
		 */
		public static $baseLayout = 'view/error/';
		/**
		 *
		 */
		public static $startPage = '/';

		/**
		 *
		 */
		public function __construct()
		{

		}

		/**
		 *
		 */
		public static function render($layout)
		{
			# Twig

			$loader1 = new \Twig_Loader_Filesystem( Config::get('views.dir') );

			$loader2 = new \Twig_Loader_Filesystem( Config::get('errors.view.dir') );

			$loader = new \Twig_Loader_Chain(array($loader1, $loader2));

			self::$twig = new \Twig_Environment($loader, array(
				'debug'       => true,
			    'cache'       => false,
			    'auto_reload' => false
			));

			$methods = get_class_methods('\Core\TwigFuncs');

			foreach ($methods as $method) {
				self::$twig->addFunction(\Core\Call::factory()->method('\Core\TwigFuncs', $method));
			}

			self::$twig->display($layout);
		}

		/**
		 *
		 */
		public static function abort($code)
		{
			$layout = self::$_ERROR[$code]['layout'];
			$layout = $layout . '.html';

			$r = \Core\App::request();
			header(self::$_ERROR[$code]['http']);
			header(self::$_ERROR[$code]['status']);

			if ($r['xhr']) {
				json_encode(array('success' => false, 'error' => self::$_ERROR[$code]['status']));
			} else {
				\View::make("_sys_errors/{$code}");
			}

			return die;
		}

		/**
		 *
		 */
		public static function abortView($layout)
		{
			ob_start();
			require_once self::$baseLayout . $layout . EXT;
			return ob_get_clean();
		}

		/**
		 *
		 */
		public static function view($message)
		{
			echo self::render(array('message'=>$message, 'page'=>self::$startPage), 'error');
			die;
		}

	}
?>
