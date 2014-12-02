<?php


namespace Core\Validate;

/**
 *
 */
class Rule
{
	public static $rules = array();

	/**
	 *
	 */
	public function check()
	{
		if (get_class($this) != __CLASS__)
			self::$rules = array();
	}

	/**
	 * is int value
	 *
	 * @return array
	 */
	public function int()
	{
		self::check();

		self::$rules[] = array(
				'function' => 'int',
				'args' => array()
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
		self::check();

		self::$rules[] = array(
				'function' => 'minLen',
				'args' => array($min)
			);

		return new self;
	}

	/**
	 * is value numeric
	 *
	 * @return array
	 */
	public function numeric()
	{
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
				'function' => 'maxLen',
				'args' => array($max)
			);

		return new self;
	}

	/**
	 * whether the value of a given expression
	 *
	 * @param  string $pattern
	 * @return array
	 */
	public function regex($pattern)
	{
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

		self::$rules[] = array(
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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

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
		self::check();

		return array(
				'function' => 'filterFunc',
				'args' => array($function)
			);
	}
}
