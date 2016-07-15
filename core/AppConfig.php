<?php

namespace core;

class AppConfig {

	static $config = [
		'dbUser' => 'root',
		'dbPass' => '',
		'dbAddress' => 'localhost',
		'dbPort' => '3306',
		'dbDatabse' => 'XeeFrame'
	];

	static public function get($key) {
		return self::$config[$key];
	}

}
