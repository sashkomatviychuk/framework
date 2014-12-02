<?php

	/**
	 *
	 */
	namespace Core\Validate;

	/**
	 *
	 */
	class Preprocess
	{
		/**
		 *
		 */
		public static $instance;

		/**
		 *
		 */
		public static function factory()
		{
			if (is_null(self::$instance)) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function __construct()
		{
		}

		/**
		 *
		 */
		public function validate($data, $all_rules)
		{
			$msg = null;

			foreach ($all_rules as $key => $rules) {
				if (!is_object($rules))
					continue;

				if (!isset($data[$key]))
					continue;

				if ($errorKey = $rules->validate($data[$key])) {
					$msg_key = "{$key}.{$errorKey}";
					$msg[$key] = array(
						"text" => Messages::get($msg_key),
						"key"  => $key
					);
					\Core\Message::add('danger', $msg[$key]);
				}
			}

			return $msg;
		}

		/**
		 *
		 */
		public function setFilter(&$key)
		{
			$filters = func_get_args();

			if (count($filters) > 1) {
				for ($i = 1; $i < count($filters); ++$i) {
					$key = \Core\Call::factory()->methodArgs('\Core\Validate\Validation', $filters[$i]['function'], array($key));
				}
			}
		}

		/**
		 *
		 */
		public function setRule(&$key, $rules)
		{
			if (!is_array($key)) {
				$key = array();
			}

			$rules = $rules->get();

			foreach ($rules as $rule) {
				array_push($key, $rule);
			}
		}
	}
