<?php

namespace api\core;

/**
 * Klasa reprezentujace blad w systemie
 * @author Tomasz
 */
class ApiException extends \core\XeeException {

	static function getInstance($error, $message) {
		$errorModel = new self();
		$errorModel->message = $message;
		$errorModel->code = $error;
		return $errorModel;
	}

}
