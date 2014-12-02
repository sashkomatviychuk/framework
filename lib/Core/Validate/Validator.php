<?php

namespace Core\Validate;

/**
 *
 */
class Validator
{
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
	public $error_key;

	/**
	 *
	 */
	public $error_field;

	/**
	 *
	 */
	public function __construct($validateRules = false)
	{
		if ($validateRules)
			$rules = $validateRules::$rules;

		if (empty($rules))
			return $this;

		if (is_array($rules))
			$this->rules = $rules;

		return $this;
	}

	/**
	 *
	 */
	public function attributes($name, $validateRules)
	{
		$rules = $validateRules::$rules;

		if (is_array($rules))
			$this->fields[$name] = $rules;

		return $this;
	}

	/**
	 *
	 */
	public function validate($value)
	{
		if (!is_array($value)) {
			return $this->exec($value);
		}

		foreach ($this->fields as $key => $rules) {
			if (!isset($value[$key]))
				continue;

			$this->rules = $rules;
			if (!$this->exec($value[$key])) {
				$this->error_field = $key;
				return false;
			}

		}

		return true;
	}

	/**
	 *
	 */
	public function exec($value)
	{
		if (empty($this->rules))
			return true;

		$validation = new Validation();

		foreach ($this->rules as $rule) {
			array_unshift($rule['args'], $value);
			if (!$validation->call($rule['function'], $rule['args'], $value)) {
				$this->error_key = $rule['function'];
				return false;
			}
		}

		return true;
	}

	/**
	 *
	 */
	public function errorKey()
	{
		return $this->error_key;
	}

	/**
	 *
	 */
	public function errorField()
	{
		return $this->error_field;
	}

	/**
	 *
	 */
	public function failed()
	{
		return $this->error_key != null;
	}
}
