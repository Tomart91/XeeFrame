<?php

namespace core\database;

class Result {

	public $result = false;

	static public function getInstance($result) {
		$model = new self();
		$model->result = $result;
		return $model;
	}

	public function getRow() {
		return $this->result->fetch(\PDO::FETCH_ASSOC);
	}

	public function getNumRows() {
		return $this->result->rowCount();
	}

	public function getSingleValue() {
		return $this->result->fetchColumn();
	}

}
