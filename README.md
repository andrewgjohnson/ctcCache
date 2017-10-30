# ctcCache

## Description

ctcCache is a PHP library to help cache results via file I/O or Memcache.  Redis support may be added but is currently unavailable.

## Warning

This code is used in production but has not been fully testing.  A large refactor will be coming before v1.0.0, use with caution and at your own risk until v1.0.0 is released.

## Acknowledgements

This project was started by [Andrew G. Johnson](https://github.com/andrewgjohnson), contact via [Twitter](http://twitter.com/andrewgjohnson), [Email](mailto:andrew@andrewgjohnson.com), [GitHub](https://github.com/andrewgjohnson) or [Online](http://www.andrewgjohnson.com/)

## Changelog

######v0.9.6 (March 3, 2016)
 * Added composer support

######v0.9.5 (March 3, 2016)
 * Added ctcCache_Query->clearCache() function

######v0.9.4 (September 29, 2015)
 * Added support for PHP's Memcached library (previously only supported Memecache library)

######v0.9.3 (April 7, 2015)
 * Added MySQL server information to the hash for cached MySQL query results

######v0.9.2 (December 18, 2013)
 * Fixed bug that allowed expiration time to be above the maximum for Memcache

######v0.9.1 (November 16, 2013)
 * Added multiple MySQL support
 * Added setting to determine whether or not empty MySQL queries should be cached

######v0.9.0 (November 16, 2013)
 * Intial public release of ctcCache