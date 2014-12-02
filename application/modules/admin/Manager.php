<?php

namespace admin;

/**
 *
 */
class Manager
{
	public function __construct()
	{}

	/**
	 * is it module with auth
	 *
	 * @return bool
	 */
	public function auth()
	{
		return true; // or false
	}

	/**
	 * return auth link
	 */
	public function authLink()
	{
		return \Url::create('adminLogin');
	}

	/**
	 * return auth router
	 */
	public function authRouter()
	{
		return 'adminLogin';
	}

	/**
	 * allowed roles for module
	 */
	public function allowedRoles()
	{
		return array( 'admin');
	}
}
