<?php
	namespace Core;
	/**
	 * Work with date and time
	 * Copy @ 2013
	 */
	class Date
	{

		public static $_format = 'd.m.Y, H:i';

		/**
		 *
		 */

		public static function time()
		{
			return time();
		}

		/**
		 *
		 */
		public static function currentDate()
		{
			return date(self::$_format);
		}

		/**
		 *
		 */
		public static function show($time)
		{
			if (is_integer($time))
				return date(self::$_format, $time);
		}

		/**
		 *
		 */
		public static function getDateInFormat($format = '')
		{
			if (!empty($format) && is_string($format))
				return date($format);
			return false;
		}

		/**
		 *
		 */
		public static function getFormat()
		{
			return self::$_format;
		}

		/**
		 *
		 */
		public static function setFormat($format)
		{
			self::$_format = $format;
		}

		/**
		 *
		 */
		public static function check($date)
		{
			return false;
		}

		/**
		 *
		 */
		public static function ampm($hour)
		{
			$hour = (int)$hour;
			return ($hour > 11) ? 'PM' : 'AM';
		}

		/**
		 *
		 */
		public static function currentDayOfYear()
		{
			return (date('z') + 1);
		}

		/**
		 *
		 */
		public static function getDay($time = null)
		{
			return (is_null($time) || !is_numeric($time)) ? date('d') : date('d', $time);
		}

		/**
		 * @param $week integer
		 * @param $year integer
		 * @return time
		 * time of monday of current week in year
		 */

		public static function startWeek($week, $year)
		{
			$first_date = strtotime("1 january ".($year ? $year : date("Y")));
	         if(date("D", $first_date)=="Mon") {
	              $monday = $first_date;
	         } else {
	              $monday = strtotime("next Monday", $first_date)-604800;
	         }
	         $plus_week = "+".($week-1)." week";
	   		return strtotime($plus_week, $monday);
		}

		/**
		 * @param $week integer
		 * @param $year integer
		 * @return time
		 * time of sunday of current week in year
		 */

		public static function endWeek($week, $year)
		{
			return (self::startWeek($week, $year) + 604799);
		}
	}
?>
