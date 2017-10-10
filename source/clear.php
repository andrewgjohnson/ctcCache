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

date_default_timezone_set('America/Winnipeg');

require_once(dirname(__FILE__) . '/ctcCache.php');

if (class_exists('Memcache'))
	ctcCache_MemcacheSingleton::get()->flush();
else
{
	if (file_exists(rtrim(dirname(__FILE__),'/\\')) && $handle = opendir(rtrim(dirname(__FILE__),'/\\') . '/cache/'))
	{
		while (false !== ($file = readdir($handle)))
		{
			if (substr($file,-4) == '.log' && filemtime(rtrim(dirname(__FILE__),'/\\') . '/cache/' . $file) < time() - CTCCACHE_MAXIMUM_CACHE_LENGTH)
				unlink(rtrim(dirname(__FILE__),'/\\') . '/cache/' . $file);
		}
		closedir($handle);
	}
}