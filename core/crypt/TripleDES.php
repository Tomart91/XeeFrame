<?php

namespace core\crypt;

class TripleDES {

	const bit_check = 8;

	static function encrypt($text) {
		$key = \core\AppConfig::get('apiKey');
		$iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$text_num = str_split($text, self::bit_check);
		$text_num = self::bit_check - strlen($text_num[count($text_num) - 1]);
		for ($i = 0; $i < $text_num; $i++) {
			$text = $text . chr($text_num);
		}
		$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
		mcrypt_generic_init($cipher, $key, $iv);
		$decrypted = mcrypt_generic($cipher, $text);
		$decrypted = $iv . $decrypted;
		return base64_encode($decrypted);
	}

	static function decrypt($encrypted_text) {
		$key = \core\AppConfig::get('apiKey');
		$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
		$encrypted_text = base64_decode($encrypted_text);
		$iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_CBC);
		$iv = substr($encrypted_text, 0, $iv_size);
		$encrypted_text = substr($encrypted_text, $iv_size);
		mcrypt_generic_init($cipher, $key, $iv);
		$decrypted = mdecrypt_generic($cipher, $encrypted_text);
		mcrypt_generic_deinit($cipher);
		$last_char = substr($decrypted, -1);
		for ($i = 0; $i < self::bit_check - 1; $i++) {
			if (chr($i) == $last_char) {
				$decrypted = substr($decrypted, 0, strlen($decrypted) - $i);
				break;
			}
		}
		return $decrypted;
	}

}
