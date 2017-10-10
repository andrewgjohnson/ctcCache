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

class ctcCache_MySqlSingleton
{
    private static $_singleton;

    public static function get()
    {
        if (self::$_singleton === null)
        {
			try
			{
				self::$_singleton = new PDO('mysql:host=' . CTCCACHE_MYSQL_HOST . (strlen(CTCCACHE_MYSQL_PORT) > 0 ? ';port=' . CTCCACHE_MYSQL_PORT : '') . ';dbname=' . CTCCACHE_MYSQL_DATABASE,CTCCACHE_MYSQL_USERNAME,CTCCACHE_MYSQL_PASSWORD);
				self::$_singleton->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
				self::$_singleton->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
				self::$_singleton->query('SET NAMES utf8');
				self::$_singleton->query('SET CHARACTER SET utf8');
				self::$_singleton->query('SET TIME_ZONE="Canada/Central"');
			}
			catch (Exception $e)
			{
				die('Error connecting to MySql.');
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