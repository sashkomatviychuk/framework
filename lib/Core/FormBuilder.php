<?php

namespace Core;

/**
 *
 */
class FormBuilder
{
	/**
	 *
	 */
	public $fields = array();

	/**
	 *
	 */
	public $attributes = array();

	/**
	 *
	 */
	public $cancel_url = '';

	/**
	 *
	 */
	public function __construct()
	{}

	/**
	 *
	 */
	public function generate()
	{
		return View::render('_sys_form/fields', array('fields' => $this->fields, 'attrs' =>$this->attributes, 'url' => $this->cancel_url ));
	}
}
