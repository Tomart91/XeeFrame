<?php

namespace core;

class Session {


	/**
	 * Funkcja pobierajaca wartość z obiektu
	 * @param <string> $key Klucz wartości która chcemy pobrać
	 * @return <mixed>
	 */
	public static function get($key) {
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	}

	/**
	 * Funkcja sprawdzajaca czy zmienna znajduje sie w obiekcie
	 * @param <string> $key Klucz do wartości która chcemy sprawdzić
	 * @return <boolean>
	 */
	public static function has($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * Funkcja wpisujaca/aktualizujaca dane w obiekcie
	 * @param <string> $key Klucz po którym wartość będzie widziana w obiekcie
	 * @param <mixed> $value
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Funkcja ustawiajaca wszystkie pola w obiekcie
	 * @param <Array> $data Dane do wpisania
	 */
	public static function setData($data) {
		$_SESSION = $data;
	}

	/**
	 * Funkcja pobierajaca wszystkie dane obiektu
	 * @return <Array> Dane obiektu
	 */
	public static function getData() {
		return $_SESSION;
	}

	public static function startSession($sesionName = 'XeeSession') {
		$secure = false;
		$httponly = true;
		session_save_path(ROOT_DIR . '/cache/' . $sesionName);
		
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
		session_name($sesionName);
		session_start();
		session_regenerate_id(true);
	}
	public static function checkLogin(){
		$userModel = new \core\auth\BasicUser();
		$userModel->checkLogin();

	}

}
