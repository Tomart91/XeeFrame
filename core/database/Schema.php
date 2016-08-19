<?php

namespace core\database;

class Schema extends Database {

	private $create = false;

	public static function getInstance() {
		return new self();
	}

	public function createTable($tableName) {
		$this->create = schema\Create::getInstance($tableName);
		return $this->create;
	}

	public function create() {
		$query = $this->create->getQuery();
		return $this->doQuery($query);
	}

	public function dropTable($tableName) {
		$query = 'DROP TABLE `' . $tableName . '`';
		$this->doQuery($query);
	}

}
