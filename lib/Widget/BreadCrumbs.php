<?php

	namespace Widget;
	/**
	 * BreadCrumbs Widget
	 * It displays a list of links indicating the position of the current page in the whole website
	 *
	 * Example:
	 * Widget_BreadCrumbs::show(array(
	 *							'url' => 'label',
	 *							));
	 */

	class BreadCrumbs
	{
		/**
		 * List of links
		 */
		public static $_links = array();

		/**
		 * Active link
		 */

		public static $_active_link = '<li><a href="{href}">{label}</a></li>';

		/**
		 * Passive Link
		 */

		public static $_no_active_link = '<li class="active">{label}</li>';

		/**
		 * Items separator
		 */

		public static $_separator = '';

		public function __construct()
		{
		}

		public static function run($links = array())
		{
			foreach ($links as $href => $label)
			{
				if (is_string($href))
				{
					self::$_links[] = strtr(self::$_active_link, array(
														'{href}' => $href,
														'{label}' => $label
													));
				}
				else
				{
					self::$_links[] = str_replace('{label}', $label, self::$_no_active_link);
				}
			}
			echo '<ul class="breadcrumb">' . implode(self::$_separator, self::$_links) . '</ul>';
		}

	}

?>
