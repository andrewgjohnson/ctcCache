<?php

/*
 * ctcCache v0.9.3
 *
 * Copyright (c) 2015 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright Copyright (c) 2015 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @link http://github.com/ctcCache/ctcCache
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 0.9.3
 * @package ctcCache
 *
 */

class ctcCache_Entry
{
	private $_cache_length = CTCCACHE_DEFAULT_CACHE_LENGTH;
	public $key = null;
	public $value = null;

	public function __construct($key,$cache_length = null)
	{
		$this->key = $key;

		if (!is_null($cache_length))
			$this->_cache_length = (int)$cache_length;

		if (class_exists('Memcache'))
		{
			$value = ctcCache_MemcacheSingleton::get()->get(md5($this->key));
			if ($value !== false)
				$this->value = $value;
		}
		else
		{
			$cache_path = dirname(__FILE__) . '/cache/' . md5($this->key) . '.log';
			if (file_exists($cache_path) && filemtime($cache_path) > time() - $this->_cache_length)
				$this->value = unserialize(file_get_contents($cache_path));
		}
	}

	public function setValue($value)
	{
		$this->value = $value;

		if ($this->_cache_length > 0)
		{
			if (class_exists('Memcache'))
				ctcCache_MemcacheSingleton::get()->set(md5($this->key),$this->value,false,min($this->_cache_length,2592000)); // 2592000 seconds is the maximum expiration time in memcache
			else
			{
				$cache_path = dirname(__FILE__) . '/cache/' . md5($this->key) . '.log';
				$create_cache = fopen($cache_path,'w');
				fputs($create_cache,serialize($value));
				fclose($create_cache);
			}
		}
	}
}