<?php

namespace core;

class AppConfig {

	static $loadCache = [];

	static private function load($type) {
		if (!isset(self::$loadCache[$type])) {
			require(ROOT_DIR . '/core/config/' . $type . '.php');
			self::$loadCache[$type] = $config;
		}
	}
	public static function getAll($type) {
		self::load($type);
		return self::$loadCache[$type];
	}
	public static function get($type, $key) {
		self::load($type);
		return self::$loadCache[$type][$key];
	}

	public static function db($key) {
		return self::get(__FUNCTION__, $key);
	}

	public static function debug($key) {
		return self::get(__FUNCTION__, $key);
	}

	public static function main($key) {
		return self::get(__FUNCTION__, $key);
	}

	public static function mime($key) {
		return self::get(__FUNCTION__, $key);
	}

}
