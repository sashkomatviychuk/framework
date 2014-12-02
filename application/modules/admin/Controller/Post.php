<?php

	/**
	 *
	 */
	namespace admin\Controller;

	/**
	 *
	 */
	use \Core\Controller as Controller;

	/**
	 *
	 */
	class Post extends Controller
	{
		/**
		 *
		 */
		public function filter()
		{
			return array(
				'ajaxOnly'  => array(),
				'getOnly'   => array(),
				'postOnly'  => array(),
				'ajaxNone'  => array(),
				'getNone'   => array(),
				'postNone'  => array(),
				'guestOnly' => array(),
				'userOnly'  => array(),
				'deny'      => array()
			);
		}

		/**
		 *
		 */
		public function accessRules()
		{
			return array(
				'guest' => array('list', 'view','create','update','delete'),
				'user'  => array('login'),
				'admin' => array()
			);
		}

		/**
		 *
		 */
		public function actionLogin()
		{
			die('Login Page=)');
		}

		/**
		 *
		 */
		public function actionList()
		{
			$this->render('post/list');
		}

		/**
		 *
		 */
		public function actionView()
		{
			$this->render('post/view');
		}

		/**
		 *
		 */
		public function actionCreate()
		{
			$this->render('post/create');
		}

		/**
		 *
		 */
		public function actionUpdate()
		{
			$this->render('post/update');
		}

		/**
		 *
		 */
		public function actionDelete()
		{

		}
	}
