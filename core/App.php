<?php

namespace core;

class App {

	static function microtimeFloat() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float) $usec + (float) $sec);
	}

}
