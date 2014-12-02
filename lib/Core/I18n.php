<?php

	namespace Core;
	/**
	 *
	 */
	class I18n
	{

		/**
		 *
		 */
		public $l = array();

		/**
		 *
		 */
		public static $instance;

		/**
		 *
		 */
		public static function factory()
		{
			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function __construct()
		{
			foreach (glob(LANGS_PATH . '*.php') as $lang) {
				$lang = basename($lang);
				list($name, $ext) = explode('.', $lang);
				$this->l[$name] =  require LANGS_PATH . "{$lang}";
			}
		}

		/**
		 *
		 */
		public function t($key)
		{
			$lang = \Core\Http\Session::get('_lang');
			$lang = isset($lang) ? $lang : 'uk';

			if ( isset($this->l[$lang]) ) {
				if ( isset($this->l[$lang][$key]) ) {
					return $this->l[$lang][$key];
				}
			}

			return '';
		}
	}
