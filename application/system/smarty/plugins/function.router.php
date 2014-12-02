<?php

function smarty_function_router($params, $smarty)
{
	$name = $params['name'];
	echo \Url::create($name, $params);
}
