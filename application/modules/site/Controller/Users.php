<?php

namespace site\Controller;

/**
 *
 */
use \Core\Controller as Controller;

/**
 *
 */
class Users extends Controller
{
	/**
	 *
	 */
	public function before()
	{
		parent::before();
	}

	/**
	 *
	 */
	public function actionList()
	{
		list($offset, $limit) = $this->pagination();
		$users = $this->model('Users')->page(array('limit' => $limit, 'offset' => $offset));

		$this->render('users/list', array('users' => $users));
	}

	/**
	 *
	 */
	public function actionView($id = null)
	{
		try {
			if (!$user = $this->model('Users')->find($id)) {
				\Error::abort(404);
			}
		} catch(\Exception $e) {
			\Error::abort(404);
		}

		$this->render('users/view', array('user' => $user));
	}

	/**
	 *
	 */
	public function actionAdd()
	{
		$form = $this->form('Register');

		if (!empty($this->_post)) {
			if (\Input::post('token') &&
			    \Security::checkToken(\Input::post('token'))) {

				unset($this->_post['token']);

				$form->data = $this->_post;

				if ($form->save()) {
					\Message::add('info', __('Користувача збережено!'));
					$this->redirectRoute('users');
				}
			} else {
				\Message::add('danger', __('Невірний токен'));
			}
		}

		$this->render('users/add', array());
	}

	/**
	 *
	 */
	public function actionEdit($id)
	{
		if (!$user = $this->model('Users')->find($id))
			\Error::abort(404);

		$form = $this->form('Register');

		if (\Input::notEmpty('post')) {
			if (\Input::post('token') &&
			    \Security::checkToken(\Input::post('token'))) {

				unset($this->_post['token']);

				$form->data = $this->_post;

				if ($form->update($id)) {
					\Message::add('info', __('Дані про користувача оновлено!'));
					$this->redirectRoute('users');
				}
			} else {
				\Message::add('danger', __('Невірний токен'));
			}
		} else {
			$_POST = $user->attributes();
			unset($this->_post['pass']);
		}

		$this->render('users/edit', array());
	}

	/**
	 *
	 */
	public function actionDelete($id = null)
	{
		try {
			if ($user = $this->model('Users')->find($id)) {
				$user->delete();
			}
		} catch(\Exception $e) {
			\Error::abort(404);
		}

		$this->redirectRoute('users');
	}

	/**
	 *
	 */
	public function actionLogin()
	{
		if (!empty($this->_post)) {
			if (\Auth::check($this->_post['login'], $this->_post['pass'])) {
				if (!empty($this->_get['r']))
					$this->redirectUrl($this->_get['r']);

				$this->redirectRoute('home');
			}
		}

		$this->render('login/login');
	}

	/**
	 *
	 */
	public function actionLogout()
	{
		if ($session = \Session::get('shadow')) {
			\Session::replace($session);
			\Message::add('info', __('Ви повернулися в свій профіль'));
			$this->redirectRoute('home');
		}

		\Auth::logout();

		$url = \Core\Url::create('login');
		if (!empty($this->_get['r']))
			$url = rtrim($url, '/') . '/?r=' . $this->_get['r'];

		$this->redirectUrl($url);
	}

	/**
	 *
	 */
	public function actionShadow($id)
	{
		if (!$user = $this->model('Users')->find($id)) {
			\Error::abort(404);
		}

		\Session::set('shadow', \Session::getAll());

		\Auth::check($user->login, $user->pass);
		\Message::add('info', __('Shadow login успішно здійснено'));
		$this->redirectRoute('home');
	}

}
