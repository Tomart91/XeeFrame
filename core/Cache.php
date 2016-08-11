<?php

namespace core;

class Cache {

	static $connector = false;

	public static function __callStatic($name, $arguments) {
		call_user_func_array([self::$connector, $name], $arguments);
	}

	static function connect() {
		$className = AppConfig::cache('defaultCache');
		$classNameFull = __NAMESPACE__ . '\\cache\\' . $className;
		$classNameFull::$config = AppConfig::cache($className);
		self::$connector = $classNameFull;
		$classNameFull::connect();
	}

}
