<?php
namespace Core;

/**
 *
 */
use Model\Users as Users,
	\Core\Http\Session as Session;

/**
 * Check user data (as login and password)
 *
 * User input params
 * 1) login, pass
 * 2) array of logins and passes to check
 */
class Auth
{
	/**
	 *
	 */
	private static $HASH = 'md5';

	/**
	 *
	 */
	private static $UKEY = '_UID';

	/**
	 *
	 */
	public function Auth()
	{
		$user = Session::get(self::$UKEY);
		if (!$user) Session::set(self::$UKEY, 'guest');
	}

	/**
	 *
	 */
	public static function check($login, $pass)
	{

		switch (self::$HASH) {
			case 'md5':
				$pass = md5($pass);
				break;

			case 'sha1':
				$pass = sha1($pass);
				break;

			case 'crypt':
				$pass = crypt($pass);
				break;

			default:
				$pass = md5($pass);
				break;
		}

		$user = Users::find(array('login' => $login, 'pass' => $pass));

		if (!empty($user)) {
			Session::set('id', $user->id);

			if (isset($user->role)) {
				Session::set('_UID', $user->role);
			} else {
				Session::set('_UID', 'user');
			}
			return true;
		}

		return false;

	}

	/**
	 *
	 */
	public function logout()
	{
		Session::set('id', null);
		Session::set('_UID', 'guest');
	}

	/**
	 *
	 */
	public static function guest()
	{
		return Session::get('_UID') == 'guest';
	}

	/**
	 *
	 */
	public static function setHash($hash)
	{
		self::$HASH = $hash;
	}

	/**
	 *
	 */
	public static function getHash()
	{
		return self::$HASH;
	}

	/**
	 * Auth::user()->login
	 * Auth::user()->id
	 */
	public function user()
	{}
}

