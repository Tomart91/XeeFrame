<?php

namespace core\database\schema;

class Create {

	private $columns = [];
	public $tableName = false;

	static public function getInstance($name) {
		$instance = new self();
		$instance->tableName = $name;
		return $instance;
	}

	public function addColumn() {
		$column = Column::getInstance();
		$this->columns [] = $column;
		return $column;
	}

	public function getQuery() {
		$query = 'CREATE TABLE ' . $this->tableName . ' (';
		foreach ($this->columns as $column) {
			$query .= $column->name . ' ' . $column->type . ' (' . $column->length . ')';
			if($column->primaryKey)
				$query .= ' PRIMARY KEY ';
			if($column->notNull)
				$query .= ' NOT NULL ';
			if($column->unsigned)
				$query .= ' UNSIGNED ';
			if($column->autoIncrement)
				$query .= ' AUTO_INCREMENT ';
			if($column->zeroFill)
				$query .= ' ZEROFILL ';
			$query .= ', ';
		}
		$query = trim($query, ', ');
		$query .= ')';
		var_dump($query);
		return $query;
	}

}
