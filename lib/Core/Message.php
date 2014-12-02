<?php

	namespace Core;

	/**
	 *
	 */
	class Message {

		/**
		 *
		 */
		public static $data = array();

		/**
		 *
		 */
		public function Message()
		{
		}

		/**
		 *
		 */
		public static function instance()
		{
			return new self;
		}

		/**
		 *
		 */
		public function add($type, $data)
		{

			if ( is_string($data) ) {
				$text = $data;
				$key = "";
			} else {
				$text = isset($data['text']) ?
							$data['text'] : "";

				$key = isset($data['key']) ?
							$data['key'] : "";
			}


			self::$data[$key] = array(
				'type' => $type,
				'text' => $text,
				'key' => $key
			);

			Http\Session::set('_msg', self::$data);
		}

		/**
		 *
		 */
		public function pop()
		{
			$data = Http\Session::get('_msg');
			Http\Session::set('_msg', array());
			return reset($data);
		}

		public function has()
		{
			return Http\Session::get('_msg');
		}

		/**
		 *
		 */
		public function push($type, $data)
		{
			// $data = array_unique($data);

			foreach ( $data as $item) {
				self::add($type, $item);
			}
		}

		/**
		 * message for next page
		 */
		public function flash($type, $data)
		{}
	}
