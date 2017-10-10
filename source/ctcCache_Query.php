<?php

/*
 * ctcCache v0.9.0
 *
 * Copyright (c) 2013 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright Copyright (c) 2013 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @link http://github.com/ctcCache/ctcCache
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 0.9.0
 * @package ctcCache
 *
 */

class ctcCache_Query
{
	private $_query = null;
	private $_parameters = array();
	private $_cache_length = 0;
	public $results = null;
	public $inserted_id = null;

	public function setQuery($query)
	{
		$this->_query = $query;
	}

	public function addParameter($parameter,$value)
	{
		$this->_parameters[] = array(
			'parameter' => $parameter,
			'value' => $value
		);
	}

	public function setCacheLength($length)
	{
		$this->_cache_length = (int)$length;
	}

	public function run()
	{
		if (is_null($this->_query))
			return false;

		if ($this->_cache_length > 0)
		{
			$hash = $this->_query;
			foreach ($this->_parameters as $parameter)
				$hash .= $parameter['parameter'] . $parameter['value'];
			$hash = md5($hash);

			$cached_results = new ctcCache_Entry($hash,$this->_cache_length);
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

		if ($this->_cache_length > 0 && sizeof($this->results) > 0)
			$cached_results->setValue($this->results);

		return true;
	}
}