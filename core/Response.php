<?php

namespace core;

class Response {

	public $valueMap;

	static public function getInstance() {
		return new self();
	}

	public function setData($data) {
		$this->valueMap = json_encode($data);
	}

	public function emit() {
		$response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this->valueMap);
		echo $response;
	}

}
