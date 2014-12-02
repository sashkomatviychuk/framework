<?php

use \Gettext\Translator;

class L10n
{
	public static $l10n;


	public static init()
	{
		if (!self::$l10n) {
			self::$L10n = new Translator();
		}
	}

	/**
	 *
	 */
	public static function _($text)
	{
		return __($text);
	}
}
