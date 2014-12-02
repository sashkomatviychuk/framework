<?php

	/**
	 *
	 */
	namespace Core\Http;

	/**
	 *
	 */
	class Cookie
	{
		/**
		 *
		 */
		private static $time = 0;

		/**
		 *
		 */
		public static $salt;

		/**
		 *
		 */
		public function __construct()
		{
		}

		/**
		 *
		 */
		public static function set($name, $value, $time_life = null)
		{
			if (!isset($time_life))
				$time_life = time()+self::$time;
			else
				$time_life +=time();
			$value = self::salt($name, $value).'~'.$value;
			setcookie($name, $value, $time_life);
		}

		/**
		 *
		 */
		public static function get($name)
		{
			if ( ! isset($_COOKIE[$name]))
				return null;

			// Get the cookie value
			$cookie = $_COOKIE[$name];

			// Find the position of the split between salt and contents
			$split = strlen(self::salt($name, NULL));

			if (isset($cookie[$split]) AND $cookie[$split] === '~')
			{
				// Separate the salt and the value
				list ($hash, $value) = explode('~', $cookie, 2);

				if (self::salt($name, $value) === $hash)
					return $value;

				// The cookie signature is invalid, delete it
				self::delete($name);
			}

			return null;
		}

		/**
		 *
		 */
		public static function delete($name)
		{
			unset($_COOKIE[$name]);
			return setcookie($name, NULL);
		}

		/**
		 *
		 */
		public static function salt($name, $value)
		{
			if ( !Cookie::$salt)
			{
				throw new Exception('A valid cookie salt is required. Please set Cookie::$salt.');
			}

			return md5($name . $value . self::$salt);
		}

	}
?>
