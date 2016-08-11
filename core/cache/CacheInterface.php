<?php

namespace core\cache;

interface CacheInterface {

	public static function get($key);

	public static function set($key, $value, $minute);

	public static function delete($key);

	public static function connect();
}
