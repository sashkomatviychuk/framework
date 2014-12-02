<?php

function smarty_function_url($params, $smarty)
{
	if (isset($params['lang'])) {
		return preg_replace('~^/[a-z]{2}~', "/{$params['lang']}", $_SERVER['REQUEST_URI']);
	} else {
		echo $_SERVER['REQUEST_URI'];
	}
}
