<?php

function smarty_block_persist($params, $content, $smarty, $repeat=false)
{
	require_once COMP_PATH . 'HTML/FormPersister.php';
	return (new \HTML_FormPersister)->process($content);
}

