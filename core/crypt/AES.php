<?php

namespace core\crypt;

class AES {

	public static function encrypt($rawText) {
		$key = \core\AppConfig::get('apiKey');
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $rawText, MCRYPT_MODE_CBC, $iv);
		$ciphertext = $iv . $ciphertext;
		$ciphertext_base64 = base64_encode($ciphertext);		
		return $ciphertext_base64;
	}

	public static function decrypt($ciphertext_base64) {
		$key = \core\AppConfig::get('apiKey');
		$ciphertext_dec = base64_decode($ciphertext_base64);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
		return $plaintext_dec;
	}

}
