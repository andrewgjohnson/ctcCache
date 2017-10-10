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

require_once(dirname(__FILE__) . '/configuration.php');
require_once(dirname(__FILE__) . '/ctcCache_Entry.php');
require_once(dirname(__FILE__) . '/ctcCache_MySqlSingleton.php');
require_once(dirname(__FILE__) . '/ctcCache_MemcacheSingleton.php');
require_once(dirname(__FILE__) . '/ctcCache_Query.php');

class ctcCache
{
    public static function disconnect_singletons()
    {
		ctcCache_MySqlSingleton::disconnect();
		if (class_exists('Memcache'))
			ctcCache_MemcacheSingleton::disconnect();
    }
}