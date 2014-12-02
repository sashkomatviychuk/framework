<?php

	/**
	 *
	 */
	namespace Utils;

	/**
	 *
	 */
	class Thumbs
	{
		/**
		 *
		 */
		public static $instance;

		/**
		 *
		 */
		public function __construct() {}

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
		public function create($file, $sizes = array())
		{

			if ( !($file instanceof \Core\File) ) {
				return false;
			}

			if ( empty($sizes) ) {
				$sizes = \Core\Config::get('thumbs');
			}

			$full_path = $file->getFullPath();
			$name      = $file->getName();
			$path      = $file->getPath();

			if (!file_exists($full_path)) {
				return false;
			}

			foreach ($sizes as $size) {
				$image     = \Core\Image::initFromPath($full_path);
				$size_path = $size;
				$size      = explode('x', $size);

				if ( empty($size) ) {
					continue;
				}

				$width  = isset($size[0]) && !empty($size[0])
				                           ? $size[0] : null;

				$height = isset($size[1]) && !empty($size[1])
				                           ? $size[1] : null;

				$image->resizeInPixel($width, true, true);
				$image->save($path, $size_path . '-' . $name);
			}
		}

		/**
		 *
		 */
		public function get($path, $filename, $sizes = array())
		{
			if ( empty($sizes) ) {
				$sizes = \Core\Config::get('thumbs');
			}

			$data  = array();
			$path  = trim($path, '/');
			$path  = "{$path}/";

			foreach ($sizes as $size) {

				$size = trim($size, 'x');
				$file = $path . $size . '-' . $filename;

				if ( file_exists($file) ) {
					$data["{$size}"] =  '/public/' . $file;
				}
			}

			$file = $path . $filename;

			if ( file_exists($file) ) {
				$data["o"] = '/public/' . $file;
			}

			return $data;
		}
	}
