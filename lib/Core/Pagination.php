<?php

	namespace Core;

	/**
	 * Pagination
	 */
	class Pagination
	{
		/**
		 *
		 */
		public $limit;

		/**
		 *
		 */
		public $start;

		/**
		 *
		 */
		public $total;

		/**
		 *
		 */
		public function __construct()
		{
			$this->limit = \Config::get('paginator.limit') ? \Config::get('paginator.limit') : \Config::get('limit');
		}

		/**
		 *
		 */
		public function setLimit($limit)
		{
			$this->limit = $limit;
			return $this;
		}

		/**
		 *
		 */
		public function setTotal($total)
		{
			$this->total = (int)$total;
			return $this;
		}

		/**
		 *
		 */
		public function getLimit()
		{
			return $this->limit;
		}

		/*
		*	data['first'] = 'nameFirst'
		*	data['last']
		*	data['prev']
		*	data['next']
		*/
		public function build($data = array())
		{
			$paginator = array();

			$pagesCountTmp = $this->total/$this->limit;
			$pagesCount = (int)$pagesCountTmp;

			($pagesCount != $pagesCountTmp) && ++$pagesCount;

			if (isset($_GET['page'])) {
				$_GET['page'] = (int)$_GET['page'];
			} else {
				$_GET['page'] = 1;
			}

			if (isset($_GET['page']) && is_int($_GET['page']) && $pagesCount > 1) {

				if ($_GET['page'] != 1) {
					$item['label'] = isset($data['prev']) ? $data['prev'] : 'Попередня';
					$item['url'] = $this->getLink($_GET['page'] - 1);
					array_push($paginator, $item);
				}

				$start = $_GET['page'] - 2;
				$end = $_GET['page'] + 2;

				for ($i = $start; $i <= $end; ++$i) {
					if ($i > 0 && $i <= $pagesCount) {
						$item['label'] = $i;
						$item['url'] = $this->getLink($i);
						array_push($paginator, $item);
					}
				}

				if ($_GET['page'] != $pagesCount) {

					$item['label'] = isset($data['next']) ? $data['next'] : 'Наступна';
					$item['url'] = $this->getLink($_GET['page'] + 1);
					array_push($paginator, $item);
				}
			}

			return $paginator;
		}

		/**
		 *
		 */
		public function getLink($id)
		{
			$base = \App::getUri();

			if (!strpos($base, '?')) {
				$base .= '?';
			}

			$base = preg_replace('/\&page\=\d+\&/', '&', $base);
			$base = preg_replace('/\&?page\=\d+\&?/', '', $base);
			$tmp  = preg_match('/\?(.*)/', $base, $m);

			$m = reset($m);

			if (strlen($m) > 1) {
				$base .= '&';
			}

			return $base . 'page=' . $id;
		}
	}
