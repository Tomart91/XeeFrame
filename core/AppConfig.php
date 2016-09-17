<?php

namespace core;

class AppConfig {

	static $loadCache = [];

	static private function load($type) {
		if (!isset(self::$loadCache[$type])) {
			$config = require(ROOT_DIR . '/core/config/' . $type . '.php');
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

	public static function __callStatic($name, $arguments) {
		return self::get($name, $arguments[0]);
	}
}
