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
			header('Content-type: text/json; charset=UTF-8');
			$response = json_encode($this->valueMap);
			$response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
		} else if ($this->type == self::CLI) {
			header('Content-type: text/plain; charset=UTF-8');
			$response = '';
			foreach ($this->valueMap as $var) {
				$response .= $var . PHP_EOL;
			}
		}
		echo $response;
	}

}
