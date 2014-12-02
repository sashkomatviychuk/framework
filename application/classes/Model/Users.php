<?php

/**
 *
 */
namespace Model;

/**
 *
 */
// use ActiveRecord\Model as ORM;

/**
 *
 */
class Users extends \Model
{
	/**
	 *
	 */
	static $before_create = array('before_create');

	/**
	 *
	 */
	static $before_update = array('before_update');

	/**
	 *
	 */
	public static $attributes;

	/**
	 *
	 */
	static $after_find = array('after_find');

	/**
	 *
	 */
	public function before_create()
	{
		// $this->time_add = time();
		if (empty($this->about))
			$this->about = '';

		$this->pass = md5($this->pass);
	}

	/**
	 *
	 */
	public function before_update()
	{
		// $this->time_add = time();
		if (empty($this->about))
			$this->about = '';

		$this->pass = md5($this->pass);
	}

	/**
	 *
	 */
	public function after_find()
	{
		die('work');
	}
}
