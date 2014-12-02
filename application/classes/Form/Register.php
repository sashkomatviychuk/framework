<?php

/**
 *
 */
namespace Form;

/**
 *
 */
use \Core\Form as Form;
use \Core\Validate\Messages as Messages;

/**
 *
 */
class Register extends Form
{
	/**
	 *
	 */
	public function rules()
	{
		// validation rules
		$this->validator->attributes('login', \Rule::minLen(4))
						->attributes('pass', \Rule::minLen(4))
						->attributes('email', \Rule::email())
						->attributes('about', \Rule::required())
						->attributes('is_active', \Rule::regex('(0|1)'));
	}

	/**
	 *
	 */
	public function messages()
	{
		// Error validation messages
		Messages::set('login.minLen', __('Значення поля Логін закоротке'));
		Messages::set('pass.minLen',  __('Значення поля Пароль закоротке'));
		Messages::set('email.email',  __('Поле email має бути валідним емейлом'));
		Messages::set('about.required',  __('Значення поля Додаткова інформація не має бути порожнім'));
		Messages::set('is_active.regex',  __('Неприпустиме значення поля Активний'));
	}

	/**
	 *
	 */
	public function build()
	{
		// set form fields
		$this->builder->fields = array(
			'token' => array('type' => 'hidden', 'attrs' => array('value' => \Security::genateToken())),
			'login' => array('type' => 'text', 'label' => 'Логін', 'attrs' => array('class' => 'form-control')),
			'pass' => array('type' => 'password', 'label' => 'Пароль', 'attrs' => array('class' => 'form-control')),
			'email' => array('type' => 'email', 'label' => 'email', 'attrs' => array('class' => 'form-control')),
			'descr' => array('type' => 'textarea', 'label' => 'Додаткова інформація', 'attrs' => array('class' => 'form-control')),
			'is_active' => array('type' => 'bool', 'label' => 'Активний' , 'text' => 'Так', 'attrs' => array('class' => '')),
		);

		// set form attributes
		$this->builder->attributes = array('action' => '', 'method' => 'POST');

		// set cancel url
		if (\App::getRoute() == 'usersEdit')
			$this->builder->cancel_url = \Url::create('usersView', array('id' => \App::getCurrParams()[0]));
		else
			$this->builder->cancel_url = \Url::create('users');
	}

	/**
	 *
	 */
	public function grid()
	{
		$limit  = \Config::get('limit');
		$offset = $this->getOffset($limit);

		return array(
			'cols' => array(
				'id' => array(),
				'login' => array(),
				'is_active' => array('values' => array('0' => 'No', '1' => 'Yes'))
			),
			'data' => $this->model('Users')->page(array('limit' => $limit, 'offset' => $offset)),
		);
	}

	/**
	 *
	 */
	public function labels()
	{
		return array(
			'id' => 'Номер',
			'login' => 'Логін',
			'pass' => 'Пароль',
			'email' => 'Емейл',
			'descr' => 'Додаткова інформація',
			'is_active' => 'Активний',
		);
	}

	/**
	 *
	 */
	public function save()
	{
		if (!$this->prepare())
			return false;

		if (empty($this->data))
			return false;

		if ($this->validate()) {
			// save some data ...
			return $this->model('Users')->create($this->data);
		}

		return false;
	}

	/**
	 *
	 */
	public function update($id)
	{
		if (!$item = $this->model('Users')->find($id))
			return false;

		if (empty($this->data))
			return false;

		if ($this->validate()) {
			$item->update_attributes($this->data);
			return true;
		}

		return false;
	}
}
