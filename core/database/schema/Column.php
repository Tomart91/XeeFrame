<?php

namespace core\database\schema;

class Column {

	public $primaryKey = false;
	public $length = 10;
	public $type = '';
	public $name = '';
	public $default = '';
	public $notNull = false;
	public $unsigned = false;
	public $autoIncrement = false;
	public $zeroFill = false;

	public static function getInstance() {
		return new self();
	}

	public function int($name) {
		$this->name = $name;
		$this->type = 'int';
		return $this;
	}

	public function string($name) {
		$this->name = $name;
		$this->type = 'varchar';
		return $this;
	}

	public function text($name) {
		$this->name = $name;
		$this->type = 'text';
		return $this;
	}

	public function dateTime($name) {
		$this->name = $name;
		$this->type = 'datetime';
		return $this;
	}

	public function length($length) {
		$this->length = $length;
		return $this;
	}

	public function notNull() {
		$this->notNull = true;
		return $this;
	}

	public function primaryKey() {
		$this->primaryKey = true;
		return $this;
	}

	public function unsigned() {
		$this->unsigned = true;
		return $this;
	}

	public function autoIncrement() {
		$this->autoIncrement = true;
		return $this;
	}

	public function zeroFill() {
		$this->zeroFill = true;
		return $this;
	}

	public function defaultValue($default) {
		$this->default = $default;
		return $this;
	}

}
