<?php

namespace core\cache;

class MemCache implements CacheInterface {

	static $cache = false;
	static $config = [];

	public static function get($key) {
		return self::$cache->get($key);
	}

	public static function set($key, $value, $seconds = 0) {
		self::$cache->set($key, $value, false, $seconds);
	}

	public static function delete($key) {
		self::$cache->delete($key);
	}

	public static function connect() {
		self::$cache = new \MemCache();
		self::$cache->connect(self::$config['host'], self::$config['port'], 30);  // connect memcahe server
	}

}
