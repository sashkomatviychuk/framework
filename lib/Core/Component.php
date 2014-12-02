<?

	/**
	* 
	*/
	class Component
	{
		public static $_config;
		
		public function __construct()
		{
		}

		public static function init($config)
		{
			self::$_config = $config;
		}

		public static function run($name)
		{
			if (is_file(self::$_config[$name]))
				require_once self::$_config[$name];
		}

		public static function runAll()
		{
			if (!empty(self::$_config))
				foreach (self::$_config  as $component) {
					if (is_file($component))
						require_once $component;
				}
		}

		public static function delete($name)
		{
			if (is_file(self::$_config[$name]))
				unset(self::$_config[$name]);
		}
	}

?>