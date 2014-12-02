<?php

	/**
	 * Set validation rules
	 *
	 * @author  <sashko1921@gmail.com>
	 * @license free
	 * @version 1.0
	 */
	namespace Core\Validate;

	/**
	 * Validation rules
	 */
	class Validator
	{
		/**
		 *
		 */
		public static $ins;
		/**
		 *
		 */
		public function __construct()
		{
		}
		/**
		 *
		 */
		public $rules = array();

		/**
		 *
		 */
		public $fields = array();

		/**
		 *
		 */
		public function get()
		{
			return $this->rules;
		}

		/**
		 * check validation for simple field
		 */
		public function validate($value)
		{
			if (empty(self::$fields) && !is_array($value)) {
				return $this->exec($value);
			}

			foreach (self::$fields as $key => $field) {
				// var_dump($field->rules);
				$this->rules = $field->rules;

				$val = $value;
				if (is_array($value) && isset($value[$key]))
					$val = $value[$key];
				else
					continue;

				if ($err = $this->exec($val))
					return $err;
			}

			return null;

		}

		/**
		 *
		 */
		public function exec($value)
		{
			if (empty($this->rules))
				return null;

			$validation = new Validation();

			foreach ($this->rules as $rule) {
				array_unshift($rule['args'], $value);
				if (!$validation->call($rule['function'], $rule['args'], $value)) {
					return $rule['function'];
				}
			}

			return null;
		}

		/**
		 *
		 */
		public function attribute($name, $validator)
		{
			$self = new self;

			$self::$fields[$name] = $validator;

			return $self;
		}

		/**
		 *
		 */
		public static function clear()
		{
			$this->rules = array();
		}

		/**
		 * is int value
		 *
		 * @return array
		 */
		public function int()
		{
			$self = self;
			$self->rules[] = array(
					'function' => 'int',
					'args' => array()
				);

			return $self;
		}

		/**
		 * is value numeric
		 *
		 * @return array
		 */
		public function numeric()
		{
			$this->rules[] = array(
					'function' => 'numeric',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is value float
		 *
		 * @return array
		 */
		public function float()
		{
			$this->rules[] = array(
					'function' => 'float',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is not empty value
		 *
		 * @return array
		 */
		public function required()
		{
			$this->rules[] = array(
					'function' => 'required',
					'args' => array()
				);

			return new self;
		}

		/**
		 *
		 */
		public function equal($value)
		{
			$this->rules[] = array(
					'function' => 'equal',
					'args' => array($value)
				);

			return new self;
		}

		/**
		 * is value less than max
		 *
		 * @param  int  $max
		 * @return array
		 */
		public function maxLen($max)
		{
			$this->rules[] = array(
					'function' => 'maxLen',
					'args' => array($max)
				);

			return new self;
		}

		/**
		 * is value more than min
		 *
		 * @param  int $min
		 * @return array
		 */
		public function minLen($min)
		{
			$self = $this;

			$this->rules[] = array(
					'function' => 'minLen',
					'args' => array($min)
				);

			return $self;
		}

		/**
		 * whether the value of a given expression
		 *
		 * @param  string $pattern
		 * @return array
		 */
		public function regex($pattern)
		{
			$this->rules[] = array(
					'function' => 'regex',
					'args' => array($pattern)
				);

			return new self;
		}

		/**
		 * whether the value of a given date expression
		 *
		 * @param  string $format
		 * @return array
		 */
		public function date($format = 'd.m.Y H:i:s')
		{
			$this->rules[] = array(
					'function' => 'date',
					'args' => array($format)
				);

			return new self;
		}

		/**
		 * is valid email value
		 *
		 * @return array
		 */
		public function email()
		{
			$this->rules[] = array(
					'function' => 'email',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is value ip-adress
		 *
		 * @return array
		 */
		public function ip()
		{
			$this->rules[] = array(
					'function' => 'ip',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is value url
		 *
		 * @return array
		 */
		public function url()
		{
			$this->rules[] = array(
					'function' => 'url',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is value bool
		 *
		 * @return array
		 */
		public function bool()
		{
			$this->rules[] = array(
					'function' => 'bool',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is value in range
		 *
		 * @param  int $min
		 * @param  int $max
		 * @return array
		 */
		public function range($min, $max)
		{
			$this->rules[] = array(
					'function' => 'range',
					'args' => array($min, $max)
				);

			return new self;
		}

		/**
		 * more than min value
		 *
		 * @param  int $min
		 * @return array
		 */
		public function min($min)
		{
			$this->rules[] = array(
					'function' => 'min',
					'args' => array($min)
				);

			return new self;
		}

		/**
		 * less than max value
		 *
		 * @param  int $min
		 * @return array
		 */
		public function max($max)
		{
			$this->rules[] = array(
					'function' => 'max',
					'args' => array($max)
				);

			return new self;
		}

		/**
		 *
		 */
		public function captcha()
		{
			$this->rules[] = array(
					'function' => 'captcha',
					'args' => array()
				);

			return new self;
		}

		/**
		 * is file
		 *
		 * @return array
		 */
		public function file()
		{
			$this->rules[] = array(
					'function' => 'file',
					'args' => array()
				);

			return new self;
		}

		/**
		 * check file extension
		 *
		 * @param  array $exts
		 * @return array
		 */
		public function fileExt($exts)
		{
			$this->rules[] = array(
					'function' => 'fileExt',
					'args' => array($exts)
				);

			return new self;
		}

		/**
		 *
		 */
		public function fileMime($mimes)
		{
			$this->rules[] = array(
					'function' => 'fileMime',
					'args' => array($mimes)
				);

			return new self;
		}

		/**
		 *
		 */
		public function fileMaxSize($size)
		{
			$this->rules[] = array(
					'function' => 'fileMaxSize',
					'args' => array($size)
				);

			return new self;
		}

		/**
		 * Filters
		 *
		 */
		public function filterEmail()
		{
			return array(
					'function' => 'filterEmail',
					'args' => array()
				);

		}

		/**
		 *
		 */
		public function filterEncoded()
		{
			return array(
					'function' => 'filterEncoded',
					'args' => array()
				);

		}

		/**
		 *
		 */
		public function filterQuotes()
		{
			return array(
					'function' => 'filterQuotes',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterSpecialChars()
		{
			return array(
					'function' => 'filterSpecialChars',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterString()
		{
			return array(
					'function' => 'filterString',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterInt()
		{
			return array(
					'function' => 'filterInt',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterFloat()
		{
			return array(
					'function' => 'filterFloat',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterUrl()
		{
			return array(
					'function' => 'filterUrl',
					'args' => array()
				);
		}

		/**
		 *
		 */
		public function filterFunc($function)
		{
			return array(
					'function' => 'filterFunc',
					'args' => array($function)
				);
		}


	}

