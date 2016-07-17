<?php

namespace core;

class AppConfig {

	static $config = [
		'dbUser' => 'root',
		'dbPass' => '',
		'dbAddress' => 'localhost',
		'dbPort' => '3306',
		'dbDatabse' => 'XeeFrame',
		'isDebug' => true
	];

	static public function get($key) {
		return self::$config[$key];
	}

}
