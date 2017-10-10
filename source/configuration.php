<?php

/*
 * ctcCache v0.9.1
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
 * @version 0.9.1
 * @package ctcCache
 *
 */

if (!defined('CTCCACHE_MYSQL_HOST'))
	define('CTCCACHE_MYSQL_HOST','');
if (!defined('CTCCACHE_MYSQL_PORT'))
	define('CTCCACHE_MYSQL_PORT','');
if (!defined('CTCCACHE_MYSQL_USERNAME'))
	define('CTCCACHE_MYSQL_USERNAME','');
if (!defined('CTCCACHE_MYSQL_PASSWORD'))
	define('CTCCACHE_MYSQL_PASSWORD','');
if (!defined('CTCCACHE_MYSQL_DATABASE'))
	define('CTCCACHE_MYSQL_DATABASE','');
if (!defined('CTCCACHE_MYSQL_COUNT'))
	define('CTCCACHE_MYSQL_COUNT',1);
if (!defined('CTCCACHE_MYSQL_SEPARATOR'))
	define('CTCCACHE_MYSQL_SEPARATOR',',');

if (!defined('CTCCACHE_MEMCACHE_HOST'))
	define('CTCCACHE_MEMCACHE_HOST','');
if (!defined('CTCCACHE_MEMCACHE_PORT'))
	define('CTCCACHE_MEMCACHE_PORT','');

if (!defined('CTCCACHE_DEFAULT_CACHE_LENGTH'))
	define('CTCCACHE_DEFAULT_CACHE_LENGTH',0);
if (!defined('CTCCACHE_MAXIMUM_CACHE_LENGTH'))
	define('CTCCACHE_MAXIMUM_CACHE_LENGTH',60 * 60 * 24 * 365);
if (!defined('CTCCACHE_CACHE_EMPTY_RESULTS_BY_DEFAULT'))
	define('CTCCACHE_CACHE_EMPTY_RESULTS_BY_DEFAULT',false);