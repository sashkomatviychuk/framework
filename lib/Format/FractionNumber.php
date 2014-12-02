<?php

namespace Format;

/**
 *
 */
class FractionNumber
{
	public $number;

	/**
	 *
	 */
	public function __construct($number = null)
	{
		$this->number = $number;
	}

	/**
	 *
	 */
	public function set($number)
	{
		$this->number = $number;
	}

	/**
	 *
	 */
	public function get()
	{
		return $this->number;
	}

	/**
	 *
	 */
	public function whole()
	{
		return intval($this->number);
	}

	/**
	 *
	 */
	public function decimal()
	{
		return preg_replace('/^\d+\.?/', '', $this->number);
	}

	/**
	 *
	 */
	public function getWithFormat($format = '')
	{
		if (empty($format))
			return $this->number;

		return printf($format, $this->number);
	}

	/**
	 *
	 */
	public function getWholeWithFormat($format = '')
	{
		$whole = $this->whole();

		return $this->format($whole, $format);
	}

	/**
	 *
	 */
	public function getDecimalWithFormat($format = '')
	{
		$decimal = $this->decimal();

		return $this->format($decimal, $format);
	}

	/**
	 *
	 */
	private function format($number, $format = '')
	{
		if (empty($format))
			return $number;

		return printf($format, $number);
	}
}
