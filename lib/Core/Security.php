<?php

	namespace Core;

	class Security
	{
		static $token;

		public function Security()
		{
		}

		public static function md5($value)
		{
			return md5($value);
		}

		public static function sha1($value)
		{
			return sha1($value);
		}

		public static function crypt($value)
		{
			return crypt($value);
		}

		public static function clearTags($value)
		{
			return strip_tags($value);
		}

		/**
		 *
		 */
		public static function genateToken()
		{
			$row = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm,.123456";
			$row = substr(str_shuffle($row), 0, 10);

			if (!self::$token) {
				$hash = md5( time() . $row . "!@#$%^&");
				self::$token = $hash;
				\Core\Http\Session::set('_token', $hash);
			}

			return self::$token;
		}

		/**
		 *
		 */
		public static function unToken()
		{
			self::$token = null;
			\Core\Http\Session::set('_token', null);
		}

		/**
		 *
		 */
		public static function checkToken($token)
		{
			return $token == \Core\Http\Session::get('_token');
		}

	}

?>
