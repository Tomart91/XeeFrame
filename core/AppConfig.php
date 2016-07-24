<?php

namespace core;

class AppConfig {

	static $config = [
		'dbUser' => 'root',
		'dbPass' => '',
		'dbAddress' => 'localhost',
		'dbPort' => '3306',
		'dbDatabse' => 'XeeFrame',
		'isDebug' => false,
		'apiKey' => 'E4HD9h4DhS23DYfhHemkS3Nf', 
		'salt' => 'abcdefghijklmn'
	];

	static public function get($key) {
		return self::$config[$key];
	}

}
