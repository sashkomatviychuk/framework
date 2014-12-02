<?php

	namespace Core;
	/**
	 * Working with javascript
	 */
	class JS
	{
		/**
		 * templates
		 */
		private $alert = 'alert("{message}");';
		private $confirm = 'confirm("{message}");';
		private $prompt = 'prompt("{message}");';

		/**
		 * js browser data
		 */
		protected $_data = array();

		public function JS()
		{
			$this->_data = array();
		}

		public function alert($message = '')
		{
			if (!empty($message))
				return '<script>' . str_replace('{message}', $message, $this->alert) . '</script>';
			return;
		}

		public function confirm($message = '')
		{
			if (!empty($message))
				return '<script>' . str_replace('{message}', $message, $this->confirm) . '</script>';
			return;
		}

		public function prompt($message = '')
		{
			if (!empty($message))
				return '<script>' . str_replace('{message}', $message, $this->prompt) . '</script>';
			return;
		}

		/**
		 *
		 */
		public function setVar($key, $val)
		{
			$this->_data[$key] = $val;
		}

		/**
		 *
		 */
		public function getVar($key)
		{
			if (isset($this->_data[$key])) {
				return $this->_data[$key];
			}

			return null;
		}

		/**
		 *
		 */
		public function getAllVars()
		{
			return $this->_data;
		}

		/**
		 *
		 */
		public function begin()
		{
			echo '<script>';
		}

		/**
		 *
		 */
		public function end()
		{
			echo '</script>';
		}

		/**
		 *
		 */
		public function putCloseScript()
		{
			$this->begin();
			echo 'self.close();';
			$this->end();
		}
	}
?>
