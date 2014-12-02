<?php

/**
 *
 */
namespace Utils;

/**
 *
 */
class Array
{

	/**
	 * subkey look like module.controller.action || controller.action
	 */
	public function makeKeys($subkey)
	{
		$keys = array();
		$keys[] = $subkey;

		$a_subkey = explode('.', $subkey);
		$count = count($a_subkey);
		if ($count > 1) {
			$maked = $a_subkey;
			$maked[$count-1] = '*'
			$keys[] = implode('.', $maked);
			$maked = $a_subkey;
			$maked[$count-2] = '*';
			$keys[] = implode('.', $maked);
			if ($count>2) {
				$maked = array();
				$maked[0] = $a_subkey[0];
				$maked[1] = '*';
				$keys[] = implode('.', $maked);
			}
		}

		$keys[] = '*';

		return $keys;
	}
}
