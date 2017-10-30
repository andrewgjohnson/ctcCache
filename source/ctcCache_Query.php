<?php

/*
 * ctcCache v0.9.6
 *
 * Copyright (c) 2013-2017 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright Copyright (c) 2013-2017 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @link http://github.com/ctcCache/ctcCache
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 0.9.6
 * @package ctcCache
 *
 */

if (!class_exists('ctcCache_Query'))
{
	class ctcCache_Query
	{
		private $_query = null;
		private $_parameters = array();
		private $_cache_length = 0;
		private $_cache_empty_results = CTCCACHE_CACHE_EMPTY_RESULTS_BY_DEFAULT;
		private $_hash = '';
		public $results = null;
		public $inserted_id = null;

		protected function generateHash()
		{
			$this->_hash  = CTCCACHE_MYSQL_HOST;
			$this->_hash .= CTCCACHE_MYSQL_PORT;
			$this->_hash .= CTCCACHE_MYSQL_USERNAME;
			$this->_hash .= CTCCACHE_MYSQL_PASSWORD;
			$this->_hash .= CTCCACHE_MYSQL_DATABASE;
			$this->_hash .= CTCCACHE_MYSQL_COUNT;
			$this->_hash .= CTCCACHE_MYSQL_SEPARATOR;
			$this->_hash .= $this->_query;
			foreach ($this->_parameters as $parameter)
				$this->_hash .= $parameter['parameter'] . $parameter['value'];
		}

		public function setQuery($query = '')
		{
			$this->_query = $query;
		}

		public function addParameter($parameter = '',$value = '')
		{
			$this->_parameters[] = array(
				'parameter' => $parameter,
				'value' => $value
			);
		}

		public function setCacheLength($cache_length = 0)
		{
			$this->_cache_length = max(0,(int)$cache_length);
		}

		public function setCacheEmptyResults($cache_empty_results = CTCCACHE_CACHE_EMPTY_RESULTS_BY_DEFAULT)
		{
			$this->_cache_empty_results = $cache_empty_results === true;
		}

		public function clearCache()
		{
			$this->generateHash();

			if (class_exists('Memcache') || class_exists('Memcached'))
				return ctcCache_MemcacheSingleton::get()->delete(md5($this->_hash));
			else
			{
				$cache_path = dirname(__FILE__) . '/cache/' . md5($this->_hash) . '.log';
				return file_exists($cache_path) ? unlink($cache_path) : false;
			}
		}

		public function run()
		{
			if (is_null($this->_query))
				return false;

			if ($this->_cache_length > 0)
			{
				$this->generateHash();

				$cached_results = new ctcCache_Entry($this->_hash,$this->_cache_length);
				if (!is_null($cached_results->value))
				{
					$this->results = $cached_results->value;
					return true;
				}
			}

			$query = ctcCache_MySqlSingleton::get()->prepare($this->_query);
			foreach ($this->_parameters as $parameter)
				$query->bindParam($parameter['parameter'],$parameter['value']);
			$query->execute();

			$this->results = $query->fetchAll(PDO::FETCH_ASSOC);
			$this->inserted_id = ctcCache_MySqlSingleton::get()->lastInsertId();

			if ($this->_cache_length > 0 && (sizeof($this->results) > 0 || $this->_cache_empty_results === true))
				$cached_results->setValue($this->results);

			return true;
		}
	}
}