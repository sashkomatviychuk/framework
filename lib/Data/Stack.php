<?php

/**
 *
 */
namespace Data;

/**
 *
 */
class Stack
{
	/**
	 *
	 */
	private $_s = array();

	/**
	 *
	 */
	public $_c = 0;

	/**
	 *
	 */
	public function Data_Stack($data = array())
	{
		if (is_array($data) && !empty($data))
		{
			foreach ($data as $key => $value) {
				$this->_s[] = $value;
				++$this->_c;
			}
		}
	}

	/**
	 *
	 */
	public function asArray()
	{
		return $this->_s;
	}

	/**
	 *
	 */
	public function pop()
	{
		if ($this->_c)
		{
			--$this->_c;
			return array_pop($this->_s);
		}
	}

	/**
	 *
	 */
	public function push($item)
	{
		if (isset($item) && !is_null($item))
		{
			$this->_s[] = $item;
			++$this->_c;
		}
	}

	/**
	 *
	 */
	public function peek()
	{
		if($this->_c)
			return $this->_d[$this->_c-1];
		return false;
	}

	/**
	 *
	 */
	public function clear()
	{
		$this->_s = array();
		$this->_c = 0;
	}

	/**
	 *
	 */
	public function contains($item)
	{
		return array_search($item,$this->_s,true)!==false;
	}

	/**
	 *
	 */
	public function getCount()
	{
		return $this->_c;
	}

}
