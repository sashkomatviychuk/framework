<?php

/**
 *
 */
namespace Data

/**
 *
 */
class Queue
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
	public function Queue($data = array())
	{
		if (is_array($data) && !empty($data))
		{
			$this->clear();
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
	public function dequeue()
	{
		if ($this->_c)
		{
			--$this->_c;
			return array_shift($this->_s);
		}
	}

	/**
	 *
	 */
	public function enqueue($item)
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
			return $this->_d[0];
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
