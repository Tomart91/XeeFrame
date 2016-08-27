<?php

namespace api\core;

/**
 * Klasa abstrakcyjna służaca  do tworzenia akcji, zawiera niezbedne funkcje bez których akcja nie może istnieć
 * 
 */
abstract class BaseAction {

	/**
	 * Sprawdza czy przesłane dane login i hasło są prawidłowe
	 * @param <string> $username nazwa uzytkownika
	 * @param <string> $password hasło ozytkownika
	 * @return boolean
	 */
	function validatePass($username, $password) {
		if ($username == 'root' && $password == '') {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Funkcja sprawdzajaca uprawnienia do akcji, wymagane dane, wymagana metoda
	 * @param <\core\Request> $request
	 * @throws <\core\ApiException> 
	 */
	function checkPermission($request) {
		// Walidacja Basic Athorization 
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			throw \api\core\ApiException::getInstance(401, 'UNAUTHORIZATION');
		}

		if (!$this->validatePass($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
			throw \api\core\ApiException::getInstance(401, 'WRONG_CREDENTIALS');
		}

		// Walidacja metody request'a
		if ($_SERVER['REQUEST_METHOD'] != $this->requireMethod) {
			throw \api\core\ApiException::getInstance(500, 'BAD_METHOD');
		}
		// Walidacja danych wejsciowych
		foreach ($this->requireData as $dataKey) {
			if (!$request->has($dataKey)) {
				throw \api\core\ApiException::getInstance(500, 'NO_MANDATORY_VALUE');
			}
		}
	}
	/**
	 * Główne ciało akcji 
	 */
	function process() {
		
	}

}
