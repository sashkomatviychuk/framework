<?php

namespace Core;

/**
 *
 */
use \ActiveRecord\Model as ORM;

/**
* This class can used to CRUD Db Table
*
* relations
* HAS_ONE, BELONGS_TO, HAS_MANY
* method:
* generateRelations
*/
/*
 return array('field_alias'=>array('model', 'forign_key'));
*/

class Model extends ORM
{
	/**
	 *
	 */
	public function page($cond = array())
	{
		$records = $this->find('all', $cond);

		if (isset($cond['limit'])) {
			\Config::set('paginator.limit', $cond['limit']);
			unset($cond['limit']);
		}

		if (isset($cond['offset']))
			unset($cond['offset']);

		if (empty($cond))
			$all = $this->count();
		else
			$all = $this->count($cond);

		\Config::set('paginator.total', $all);

		return $records;
	}
}
