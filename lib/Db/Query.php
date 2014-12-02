<?
	/**
	* select, selectRow, selectCol, selectCell, selectPage, query
	* QUERY_BUILDER: query execute in method biuld
	* select
	* insert
	* update
	* delete
	* where
	* or_where
	* and_where
	* order_by
	* limit
	* distinct
	* group_by
	* count
	* having
	* or_having
	* and_having
	* offset +
	* execute +
	* left_-right_-inner_join, on
	* selectRow, selectAll, selectCell, selectCol +
	*/

	class Db_Query
	{
		public $_db;

		public $_query_params = array();

		public $_last_id;

		protected $_query_string;

		public function Db_Query()
		{	
			$this->_db = Db_Connection::get();
		}	

		public function clearQueryParams()
		{
			$this->_query_params = array();
		}

		public function addParamToEnd($item)
		{
			array_push($this->_query_params, $item);
		}

		public function addParamToStart($item)
		{
			array_unshift($this->_query_params, $item);
		}

		public function clearQueryString()
		{
			$this->_query_string = '';
		}

		public function skip($param = array())
		{
			foreach ($param as $key =>$value) {
				if (is_null($value) || !isset($param[$key]) || empty($value))
					$param[$key] = DBSIMPLE_SKIP;
			}
			return $param;
		}

		public function execute()
		{
			$this->addParamToStart($this->_query_string);
			$this->_query_params = $this->skip($this->_query_params);
		    return Core::executeClassMethod($this->_db, 'query', $this->_query_params);
		}

		public function fetchAll()
		{
			$this->addParamToStart($this->_query_string);
			$this->_query_params = $this->skip($this->_query_params);
			return Core::executeClassMethod($this->_db, 'select', $this->_query_params);
			//return $this->_query_params;
		}

		public function fetchRow()
		{
			$this->addParamToStart($this->_query_string);
			$this->_query_params = $this->skip($this->_query_params);
			return Core::executeClassMethod($this->_db, 'selectRow', $this->_query_params);
		}

		public function fetchCell()
		{
			$this->addParamToStart($this->_query_string);
			$this->_query_params = $this->skip($this->_query_params);
			return Core::executeClassMethod($this->_db, 'selectCell', $this->_query_params);
		}

		public function fetchCol()
		{
			$this->addParamToStart($this->_query_string);
			$this->_query_params = $this->skip($this->_query_params);
			return Core::executeClassMethod($this->_db, 'selectCol', $this->_query_params);
		}

		public function getLastId()
		{
			return $this->_last_id;
		}
		/**
		 *
		 *   *****  	* ******	   # 		* *****		  *****      ***********
		 * *       *	*			  #			*			*		*	      *
		 * *			*			  #			*			*				 *
		 *   *****		* ***		 # 			* ***		*				 *
		 *         *	*			 #			*			*				*
		 * *       *	*			#			*			*		*		*
		 *   *****    	* ******	# ##### 	* *****		  *****		   *
		 */

		public function select($condition = '*')
		{
			$this->clearQueryString();
			$this->clearQueryParams();
			$this->_query_string = 'SELECT '. $condition;
			return $this;
		}

		public function distinct()
		{
			$this->_query_string = str_replace('SELECT', 'SELECT DISTINCT', $this->_query_string);
			return $this;
		}

		public function from($table)
		{
			$this->_query_string .= ' FROM ' . $table;
			return $this;
		}

		public function where($var, $condition = '=', $bind = '?', $value = null)
		{
			$this->_query_string .= ' WHERE 1=1 { AND ' . $var . $condition . $bind . '}';
			$this->addParamToEnd($value);
			return $this;
		}

		public function or_where($var, $condition = '=', $bind = '?', $value = null)
		{
			$this->_query_string .= ' {OR ' . $var . $condition . $bind . '}';
			$this->addParamToEnd($value);
			return $this;
		}

		public function and_where($var, $condition = '=', $bind = '?', $value = null)
		{
			$this->_query_string .= ' {AND '.$var . $condition . $bind . '}';
			$this->addParamToEnd($value);
			return $this;
		}

		public function order_by($var, $order = 'ASC')
		{
			$this->_query_string .= ' ORDER BY '. $var . $order;
			return $this;
		}

		public function group_by($var)
		{
			$this->_query_string .= ' GROUP BY '. $var;
			return $this;
		}

		public function limit($limit)
		{
			if (is_numeric($limit))
				$this->_query_string .= ' LIMIT '. $limit;
			return $this;
		}

		public function offset($start)
		{
			if (is_numeric($start))
				$this->_query_string .= ' OFFSET ' . $start;
			return $this;
		}

		public function count($fields = '*')
		{
			$this->_query_string = str_replace('SELECT', 'SELECT COUNT('.$fields.')', $this->_query_string);
			return $this;
		}

		public function having($var, $condition = '=', $value)
		{
			$this->_query_string .= ' HAVING '. $var . $condition . $value;
			return $this;
		}

		public function and_having($var, $condition = '=', $value)
		{
			$this->_query_string .= ' {AND '. $var . $condition . $value . '}';
			return $this;
		}

		public function or_having($var, $condition = '=', $value)
		{
			$this->_query_string .= ' {OR '. $var . $condition . $value . '}';
			return $this;
		}

		public function left_join($table)
		{
			$this->_query_string .= ' LEFT JOIN '. $table;
			return $this;
		}

		public function right_join($table)
		{
			$this->_query_string .= ' RIGHT JOIN '. $table;
			return $this;
		}

		public function inner_join($table)
		{
			$this->_query_string .= ' INNER JOIN '. $table;
			return $this;
		}

		public function on($var1, $condition = '=', $var2)
		{
			$this->_query_string .= ' ON ' . $var1 . $condition . $var2;
			return $this;
		}


		public function insert_into($table)
		{
			$this->clearQueryString();
			$this->clearQueryParams();
			$this->_query_string = 'INSERT INTO '. $table;
			return $this;
		}

		public function values($insert = array())
		{
			$this->_query_string .= ' SET ?a';
			$this->addParamToEnd($insert);
			return $this;
		}


		public function update($table)
		{
			$this->clearQueryString();
			$this->clearQueryParams();
			$this->_query_string = 'UPDATE '. $table;
			return $this;
		}

		public function set($update = array())
		{
			$this->_query_string .= ' SET (?a)';
			$this->addParamToEnd($update);
			return $this;
		}

		public function delete()
		{
			$this->clearQueryParams();
			$this->_query_string = 'DELETE ';
			return $this;
		}

		public function relations($relations)
		{
			$this->_query_string .= $relations;
			return $this;
		}

	}

?>