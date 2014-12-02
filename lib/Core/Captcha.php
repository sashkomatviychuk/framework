<?php

/**
 *
 */
namespace Core;

/**
 *
 */
use \Core\Http\Session as Session;

/**
 *
 */
class Captcha
{
	/**
	 *
	 */
	public static $instance;

	/**
	 *
	 */
	protected $code;

	/**
	 *
	 */
	public function __construct()
	{
	}

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
	public function setCode($code)
	{
		Session::set('_code', md5($code));
	}

	/**
	 *
	 */
	public function getCode()
	{
		return Session::get('_code');
	}

	/**
	 *
	 */
	public function create()
	{
		$im        = imagecreatetruecolor(120, 50);
		$bgc       = imagecolorallocate($im, 255, 255, 255);
		$textcolor = imagecolorallocate($im, 0, 0, 0);

		imagefilledrectangle($im, 0, 0, 120, 60, $bgc);
		$this->drawText($im);
		header('Content-Type: image/jpeg');
		imagejpeg($im);
		imagedestroy($im);
	}

	/**
	 *
	 */
	public function drawText($im)
	{
		$textcolor = imagecolorallocate($im, 0, 0, 0);
		$font      = PUBLIC_PATH . 'fonts/arial.ttf';
		$text      = $this->generateText();
		$x         = 12;
		$y         = 35;
		$len       = strlen($text);

		$this->setCode($text);

		for ($i = 0; $i < $len; ++$i) {
			$ang = rand(-10, 15);
			imagettftext($im, 16, $ang, $x, $y, $textcolor, $font, $text[$i]);
			$x += 14;
		}
	}

	/**
	 *
	 */
	public function generateText()
	{
		$hash = md5( $_SERVER['REMOTE_ADDR'] .  rand(0, 100) . time() . '$000q');
		return strtoupper(substr($hash, 0, 6));
	}

	/**
	 *
	 */
	public function check($code)
	{
		return md5($code) == $this->getCode();
	}
}
