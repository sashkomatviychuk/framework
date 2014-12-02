<?php

/**
 *
 */
namespace Core;

/**
 *
 */
class Form
{
	/**
	 *
	 */
	public $data = array();

	/**
	 *
	 */
	public $rules = array();

	/**
	 *
	 */
	public $labels = array();

	/**
	 *
	 */
	public $validator;

	/**
	 *
	 */
	public $builder;

	/**
	 *
	 */
	public $rendered;

	/**
	 *
	 */
	public function __construct($data = array())
	{
		$this->data = $data;
		$this->validator = new \Validator();
		$this->builder = new \FormBuilder();
		$this->rules();
		$this->messages();
		$this->labels = $this->labels();
	}

	/**
	 * load Model
	 */
	public function model($name)
	{
		$items = explode('\\', $name);
		foreach ($items as &$item) {
			$item = ucfirst(strtolower($item));
		}
		$name = '\Model\\' . implode('\\', $items);

		return new $name;
	}

	/**
	 *
	 */
	public function prepare()
	{
		return true;
	}

	/**
	 * validate
	 */
	public function validate()
	{
		if (!$this->validator->validate($this->data)) {
			$errorKey   = $this->validator->errorKey();
			$errorField = $this->validator->errorField();
			$label = "{$errorField}.{$errorKey}";
			$msg[$errorField] = array(
				"text" => \Core\Validate\Messages::get($label),
				"key"  => $errorField
			);

			\Message::add('danger', $msg[$errorField]);

			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function __set($key, $value)
	{
		$this->$key = $value;
	}

	/**
	 *
	 */
	public function __get($key)
	{
		return $this->$key;
	}

	/**
	 *
	 */
	public function rules()
	{}

	/**
	 *
	 */
	public function messages()
	{}

	/**
	 *
	 */
	public function generate()
	{
		$this->build();

		if (!$this->rendered)
			$this->rendered = $this->builder->generate();

		return $this->rendered;
	}

	/**
	 *
	 */
	public function build()
	{}

	/**
	 *
	 */
	public function labels()
	{
		return array();
	}

	/**
	 *
	 */
	public function getOffset($limit)
	{
		if (!isset($_GET['page']))
			return 0;

		if ($_GET['page'] <= 1)
			$_GET['page'] = 1;

		return ($_GET['page'] - 1) * $limit;
	}
}
