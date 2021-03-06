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

if (!class_exists('ctcCache_MemcacheSingleton'))
{
	class ctcCache_MemcacheSingleton
	{
	    private static $_singleton;

	    public static function get()
	    {
	        if (self::$_singleton === null)
	        {
				try
				{
					if (class_exists('Memcache'))
					{
						self::$_singleton = new Memcache();
						self::$_singleton->connect(CTCCACHE_MEMCACHE_HOST,CTCCACHE_MEMCACHE_PORT);
					}
					else if (class_exists('Memcached'))
					{
						self::$_singleton = new Memcached();
						self::$_singleton->addServer(CTCCACHE_MEMCACHE_HOST,CTCCACHE_MEMCACHE_PORT);
					}
				}
				catch (Exception $e)
				{
					die('Error connecting to Memcache.');
				}
	        }

	        return self::$_singleton;
	    }

	    public static function disconnect()
	    {
	        if (self::$_singleton !== null)
				self::$_singleton = null;
	    }
	}
}