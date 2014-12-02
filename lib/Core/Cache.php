<?php

	/**
	 *
	 */
	namespace Core;

	/**
	 * Клас для роботи з кешуванням сторінок
	 */
	class Cache
	{
		/**
		 * cache life time
		 */
		public $_life;

		/**
		 * Constructor
		 */
		public function Cache()
		{
			$this->_life = Config::get('cache.life');
		}

		/**
		 * SetCache
		 * creates a cache file(with page content)
		 */
		public function set( $file_name, $data )
		{
			$cacheFile = CACHE_PATH . DS . md5($file_name) . EXT;
			file_put_contents($cacheFile , str_replace("\n", "", $data)) ;
			//touch( $cacheFile, ( time() + intval( $lifetime ) ) ) ;
		}

		/**
		 * GetCache
		 * get page content(if file exist)
		 * @return content
		 */
		public function get($file_name)
		{
			$this->clean();
			$cacheFile = CACHE_PATH . DS . md5($file_name) . EXT;
			if (!file_exists($cacheFile)) return false;

			return file_get_contents($cacheFile);
		}

		/**
		 * Delete old files
		 */
		public function clean()
		{
			$files = scandir( rtrim(CACHE_PATH, '/' )) ; // Получаем список всего, что есть в директории кэша
			foreach( $files as $file ) { // Прокручиваем список в цикле
				if( is_file(CACHE_PATH . DS . $file) && ( $file !== '.' ) && ( $file !== '..' ) && ((filectime(CACHE_PATH . DS . $file) + $this->_life) < time()))
					unlink( CACHE_PATH . DS . $file);
			}
		}

		/**
		 * Delete file by name
		 */
		public function delete($file_name)
		{
			unlink(CACHE_PATH . DS . $file_name . EXT);
		}
	}

?>
