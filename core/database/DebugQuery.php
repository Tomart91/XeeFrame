<?php

namespace core\database;

class DebugQuery extends \core\BaseObject {

	static public function getInstance($data) {
		$instance = new self();
		$instance->setData($data);
		return $instance;
	}
	public function displayParams(){
		$params = $this->get('params');
		return implode(',', $params);
	}
}
