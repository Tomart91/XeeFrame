<?php

namespace core;

class Response {

	const JSON = 0;
	const CLI = 1;

	public $valueMap;
	public $type = self::JSON;

	static public function getInstance() {
		return new self();
	}

	public function setData($data) {
		$this->valueMap = $data;
	}

	public function emitType($type) {
		$this->type = $type;
	}

	public function emit() {
		if ($this->type == self::JSON) {
			$response = json_encode($value);
		} else if ($this->type == self::CLI) {
			$response = '';
			foreach ($this->valueMap as $var) {
				$response .= $var . PHP_EOL;
			}
		}
		$response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
		echo $response;
	}

}
