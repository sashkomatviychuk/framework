<?php

namespace Collections;

/**
 *
 */
class Array
{
	/**
	 *
	 */
	public $data = array();

	/**
	 *
	 */
	public function __construct($data = array())
	{
		$this->data = $data;
	}

	/**
	 *
	 */
	public function empty()
	{
		return empty($this->data);
	}

	/**
	 *
	 */
	public function hasKey($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 *
	 */
	public function push($val = array())
	{
		if (empty($val))
			return false;

		if (is_array($val)) {
			$this->data = array_merge($this->data, $val);
		}

		array_push($this->data, $val);
	}

	/**
	 *
	 */
	public function pop()
	{
		return array_pop($this->data);
	}

	/**
	 *
	 */
	public function shift()
	{}

	/**
	 *
	 */
	public function unshift()
	{}

	/**
	 *
	 */
	public function get()
	{
		return $this->data;
	}

	/**
	 *
	 */
	public function set($data = array())
	{
		$this->data = $data;
	}

	/**
	 *
	 */
	public function clear()
	{
		$this->data = array();
	}

	/**
	 *
	 */
	public function keys()
	{
		return array_keys($this->data);
	}

	/**
	 *
	 */
	public function values()
	{
		return array_values($this->data);
	}

	/**
	 *
	 */
	public function reset()
	{
		if ($this->empty())
			return false;

		return reset($this->data);
	}

	/**
	 *
	 */
	public function end()
	{
		if ($this->empty())
			return false;

		return end($this->data);
	}

	/**
	 *
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 *
	 */
	public function shuffle()
	{
		return $this->data = shuffle($this->data);
	}

	/**
	 *
	 */
	public function equal($data = array())
	{
		return $this->data == $data;
	}

	/**
	 *
	 */
	public function flip()
	{
		return $this->data = array_flip($this->data);
	}

	/**
	 *
	 */
	public function indexesVals()
	{
		$indexes = func_get_args();

		$res = array();
		foreach ($indexes as $index) {
			if (isset($data[$index])) {
				$res[$index] = $data[$index];
			} else {
				$res[$index] = null;
			}
		}

		return $res;
	}

	/**
	 *
	 */
	public function indexVal($index)
	{
		if (isset($this->data[$index]))
			return $this->data[$index;

		return null;
	}

	/**
	 *
	 */
	public function allIndexesIsset()
	{
		$indexes = func_get_args();
		foreach ($indexes as $index) {
			if (!isset($data[$index])) {
				return false;
			}
		}

		return true;
	}

	/**
	 *
	 */
	public function insert($key, $value)
	{
		return $this->data[$key] = $value;
	}

	/**
	 *
	 */
	public function remove($index)
	{
		if (isset($this->data[$index]))
			unset($this->data[$index]);

		return $this->data;
	}
}
