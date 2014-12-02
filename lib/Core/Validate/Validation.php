<?php

	/**
	 * Validate data process
	 *
	 *
	 */
	namespace Core\Validate;

	/**
	 *
	 */
	class Validation
	{
		/**
		 *
		 */
		public function call($rule, $args = array())
		{
			return \Core\Call::factory()->methodArgs($this, $rule, $args);
		}

		/**
		 * validate int
		 *
		 * @param  $val
		 * @return bool
		 */
		public function int($val)
		{
			return filter_var($val, FILTER_VALIDATE_INT);
		}

		/**
		 *
		 */
		public function numeric($val)
		{
			return is_numeric($val);
		}

		/**
		 *
		 */
		public function float($val)
		{
			return filter_var($val, FILTER_VALIDATE_FLOAT);
		}

		/**
		 *
		 */
		public function required($val)
		{
			return !empty($val);
		}

		/**
		 *
		 */
		public function minLen($val, $len)
		{
			return strlen($val) >= $len;
		}

		/**
		 *
		 */
		public function maxLen($val, $len)
		{
			return strlen($val) <= $len;
		}

		/**
		 *
		 */
		public function regex($val, $pattern)
		{
			$pattern = '~' . $pattern . '~';
			return preg_match($pattern, $val);
		}

		/**
		 *
		 */
		public function equal($val, $equal)
		{
			return $val == $equal;
		}

		/**
		 *
		 */
		public function date($date, $format = 'd.m.Y H:i:s')
		{
			$d = DateTime::createFromFormat($format, $date);
    		return $d && $d->format($format) == $date;
		}

		/**
		 *
		 */
		public function email($val)
		{
			return filter_var($val, FILTER_VALIDATE_EMAIL);
		}

		/**
		 *
		 */
		public function ip($val)
		{
			return filter_var($val, FILTER_VALIDATE_IP);
		}

		/**
		 *
		 */
		public function url($val)
		{
			return filter_var($val, FILTER_VALIDATE_URL);
		}

		/**
		 *
		 */
		public function bool($val)
		{
			return filter_var($val, FILTER_VALIDATE_BOOLEAN);
		}

		/**
		 *
		 */
		public function range($val, $min, $max)
		{
			if (!is_numeric($val)) {
				return false;
			}

			return ($val >= $min && $val <= $max);
		}

		/**
		 *
		 */
		public function min($val, $min)
		{
			if (!is_numeric($val)) {
				return false;
			}

			return ($val >= $min);
		}

		/**
		 *
		 */
		public function max($val, $max)
		{
			if (!is_numeric($val)) {
				return false;
			}

			return ($val <= $max);
		}

		/**
		 *
		 */
		public function captcha($val)
		{
			$code = \Core\Captcha::factory()->getCode();
			return $code === $val;
		}

		/**
		 *
		 */
		public function file($val)
		{
			return file_exists($val);
		}

		/**
		 *
		 */
		public function fileExt($val, $values = array())
		{
			if (!empty($values)) {
				$ext = pathinfo($val, PATHINFO_EXTENSION);
				return in_array($ext, $values);
			}

			return true;
		}

		/**
		 *
		 */
		public function fileMime($val, $values = array())
		{
			if (!is_file($val)) {
				return false;
			}

			if (empty($values)) {
				return true;
			}

			if (function_exists('finfo_open') === true) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE);

				if (is_resource($finfo) === true)
				{
					$result = finfo_file($finfo, $val);
				}

				finfo_close($finfo);
			}
			elseif (function_exists('mime_content_type') === true) {
				$result = preg_replace('~^(.+);.*$~', '$1', mime_content_type($val));
			}
			else {
				return false;
			}

			return in_array($result, $values);
		}

		/**
		 *
		 */
		public function fileMaxSize($val, $maxSize)
		{
			if (file_exists($val)) {
				return (filesize($val) >= $maxSize);
			}

			return false;
		}

		/**
		 * Filters
		 */
		/**
		 *
		 */
		public function filterEmail($val)
		{
			return filter_var($val, FILTER_SANITIZE_EMAIL);
		}

		/**
		 *
		 */
		public function filterEncoded($val)
		{
			return filter_var($val, FILTER_SANITIZE_ENCODED);
		}

		/**
		 *
		 */
		public function filterQuotes($val)
		{
			return filter_var($val, FILTER_SANITIZE_MAGIC_QUOTES);
		}

		/**
		 *
		 */
		public function filterSpecialChars($val)
		{
			return filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS);
		}

		/**
		 *
		 */
		public function filterString($val)
		{
			return filter_var($val, FILTER_SANITIZE_STRING);
		}

		/**
		 *
		 */
		public function filterInt($val)
		{
			return (int)filter_var($val, FILTER_SANITIZE_NUMBER_INT);
		}

		/**
		 *
		 */
		public function filterFloat($val)
		{
			return (float)filter_var($val, FILTER_SANITIZE_NUMBER_FLOAT);
		}

		/**
		 *
		 */
		public function filterUrl($val)
		{
			return filter_var($val, FILTER_SANITIZE_URL);
		}

	}

?>
