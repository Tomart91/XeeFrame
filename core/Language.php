<?php

namespace core;

class Language {

	static $defaultModule = '';
	static $lang = 'pl_pl';

	public function translate($key, $module = '') {
		if (empty($module)) {
			$module = self::$defaultModule;
		}
		require 'modules/' . $module . '/lang/' . self::$lang . '.php';
		if (isset($phpLang[$key])) {
			return $phpLang[$key];
		} else {
			require 'view/lang/' . self::$lang . '.php';
			if (isset($phpLang[$key])) {
				return $phpLang[$key];
			} else {
				return $key;
			}
		}
		return $key;
	}

}
