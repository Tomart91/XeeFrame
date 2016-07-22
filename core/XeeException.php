<?php

namespace core;

class XeeException extends \Exception {

	public static $errors;
	static function errorHandler($errno, $errstr, $errfile, $errline) {
		self::$errors[]= [
			'errorNo' => $errno,
			'errorstr' => $errstr,
			'errorFile' => $errfile,
			'errorLine' => $errline,
			'backTrace' => self::getBackTrace()
		];

	}
	static function getBackTrace(){
		$backTrace = debug_backtrace();
		$track = [];
		unset($backTrace[0]);
		unset($backTrace[1]);
		foreach($backTrace as $trace){
			$step = '';
			if(isset($trace['file'])){
				$step = $trace['file'] . '(' . $trace['line'] . ')  ';
			}			
			if(isset($trace['class'])){
				$step .= $trace['class'] . '->' . $trace['function'] . '()';
			} else {
				$step .= $trace['function'] . '()';	
			}
			$track []= $step;
		}
		return $track;
	}
	public static function fatalErrorHandler() {
		$last_error = error_get_last();
		if ($last_error['type'] === E_ERROR) {
			self::errorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
		}
	}

}
