<?php

	/**
	 *
	 */
	namespace Db;

	/**
	 *
	 */
	class Connection
	{
		/**
		 *
		 */
		private static $_connection;

		/**
		 *
		 */
		public function Connection()
		{
		}

		/**
		 *
		 */
		public static function init()
		{
			$config = \Core\Config::get('database');
			$connect = 'mysql://'.$config['user'].':'.$config['pass'].'@'.$config['host'].'/'.$config['name'];
			self::$_connection = \DbSimple_Generic::connect($connect);
		}

		/**
		 *
		 */
		public static function set($config = array())
		{
			if (is_array($config) && !empty($config))
			{
				$connect = 'mysql://'.$config['user'].':'.$config['pass'].'@'.$config['host'].'/'.$config['name'];
				self::$_connection = \DbSimple_Generic::connect($connect);
			}
		}

		/**
		 *
		 */
		public static function get()
		{
			return self::$_connection;
		}

		/**
		 *
		 */
		public static function delete()
		{
			unset(self::$_connection);
		}
	}

?>
