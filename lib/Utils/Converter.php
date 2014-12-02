<?php

	namespace Utils;

	/**
	 *
	 */
	class Converter
	{
		/**
		 *
		 */
		public function __construct() {}

		/**
		 *
		 */
		public static function toArray($obj)
		{
			if (!is_object($obj)) {
				return false;
			}

			$a = (array)$obj;

			foreach ($a as $v => $i) {
				if (strpos($v, 'attribut')!== false) {
					$data = $i;
				}
			}

			return $data;
		}
	}
