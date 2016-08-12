<?php

namespace core;

class App {

	static function microtimeFloat() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float) $usec + (float) $sec);
	}

	static function import($file) {
		
		return require ROOT_DIR . $file;
	}

	static function getVersion() {
		return self::import('/core/version.php');
	}

}
