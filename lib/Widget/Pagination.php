<?php

	namespace Widget;

	/**
	 *
	 */
	class Pagination
	{
		/**
		 *
		 */
		public static $_tmp = '<li><a href="{url}">{label}</a></li>';

		/**
		 *
		 */
		public static $_tmpSpan = '<li class="active"><span>{label}</span></li>';

		/**
		 *
		 */
		public static function run()
		{
			$args  =  func_get_args();

			if (count($args) == 0) {
				return false;
			}

			$model = '\Model\\' . $args[0];
			$model = new $model;

			$paginator = new \Core\Pagination();
			$list = array();
			$total = \Config::get('paginator.total') ? \Config::get('paginator.total') : $model->count();

			$data = $paginator->setTotal($total)->build();

			foreach ($data as $item) {
				if ($_GET['page'] == $item['label']) {
					$list[] = strtr(self::$_tmpSpan, array(
												'{label}' => $item['label']
											));
				} else {
					$list[] = strtr(self::$_tmp, array(
												'{url}' => $item['url'],
												'{label}' => $item['label']
											));
				}
			}

			echo '<ul class="pagination">' . implode(' ', $list) . '</ul>';
		}
	}

