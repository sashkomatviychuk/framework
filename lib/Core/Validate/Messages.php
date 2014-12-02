<?php

	namespace Core\Validate;

	/**
	 *
	 */
	class Messages {

		/**
		 *
		 */
		public static $messages = array();

		/**
		 *
		 */
		public function Messages()
		{
		}

		/**
		 *
		 */
		public function set( $key, $msg )
		{
			self::$messages[$key] = $msg;
		}

		/**
		 *
		 */
		public function get( $key )
		{
			if ( isset(self::$messages[$key]) ) {
				return self::$messages[$key];
			}

			return "";
		}

		/**
		 *
		 */
		public function all()
		{
			return self::$messages;
		}

	}
