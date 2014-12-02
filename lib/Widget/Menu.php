<?php

	namespace Widget;

	/**
	 *
	 */
	class Menu
	{
		public static $_list = array();

		public static $_item = '<li {attr}><a href="{href}">{label}</a></li>';

		public static $_separator = '&nbsp;';

		public static $_active_class = 'active';

		public function Widget_Menu()
		{
		}

		public static function run($items = array())
		{
			if (!empty($items))
			{
				foreach ($items as $item)
				{
					$item['attr'] = '';
					$link = '/' . rtrim($item['url'], '/');

					// if (App::getCurrController() == $item['controller'] && App::getCurrAction()==$item['action'] )
					// 	$item['attr']['class'] = self::$_active_class;

					if (!empty($item['attr']))
						$item['attr'] = HTML::makeAttrString($item['attr']);
					self::$_list[] = strtr(self::$_item, array(
														'{href}' => $link,
														'{label}' => $item['label'],
														'{attr}' => $item['attr']
													));
				}

				echo implode(self::$_separator, self::$_list);
			}
		}
	}

?>
