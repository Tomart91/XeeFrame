<?php

namespace core\database;

use \core\AppConfig;
use core\database\Result;

class Database {

	static $database = false;
	private $query = '';
	private $params = [];
	protected $nameQuote = '`';
	public static $debugQuery = [];

	static function connect() {
		$dsn = 'mysql:dbname=' . AppConfig::get('dbDatabse') . ';host=' . AppConfig::get('dbAddress');
		$user = AppConfig::get('dbUser');
		$password = AppConfig::get('dbPass');
		self::$database = new \PDO($dsn, $user, $password);
	}

	static function getInstance() {
		return new self();
	}

	public function doQuery($query, $params = []) {
		$timeStart = microtime(true);
		$stmt = self::$database->prepare($query);
		$stmt->execute($params);
		self::$debugQuery [] = DebugQuery::getInstance([
					'query' => $query,
					'params' => $params,
					'time' =>  microtime(true) - $timeStart
		]);
		return Result::getInstance($stmt);
	}

	public function select($select, $state = 'SELECT') {
		foreach ($select as &$sel) {
			if($sel != '*')
				$sel = $this->quoteName($sel);
		}
		$this->query = $state . ' ' . implode(',', $select);
		return $this;
	}

	public function update($tableName, array $data) {
		$this->query = $this->printf('UPDATE %s SET ', $tableName);
		foreach ($data as $column => $value) {
			$this->query .= $this->printf('%s = ?,');
			$this->params [] = $value;
		}
		$this->query = trim($this->query, ',');
		return $this;
	}
	public function delete() {
		$this->query = 'DELETE ';
		return $this;
	}
	public function insert($tableName, array $data) {
		$this->query = $this->printf('INSERT INTO %s SET ', $tableName);
		$this->params = [];
		foreach ($data as $column => $value) {
			$this->query .= $this->printf('%s = ?,', $column);
			$this->params [] = $value;
		}
		$this->query = trim($this->query, ',');
		$this->toDo();
	}

	public function from($table) {
		$this->query .= $this->printf(' FROM %s', $table);

		return $this;
	}

	public function where($where, array $params) {
		$this->query .= sprintf(' WHERE %s', $where);
		$this->params = $params;
		return $this;
	}

	public function orderBy($column, $inc) {
		if (in_array($inc, ['ASC', 'DESC'])) {
			$this->query .= $this->printf(" ORDER BY %s $inc", $column);
		}
		return $this;
	}

	public function limit($start, $count = 0) {
		if ($count == 0) {
			$this->query .= $this->printf(' LIMIT %d', $start);
		} else {
			$this->query .= $this->printf(' LIMIT %d, %d', $start, $count);
		}

		return $this;
	}

	public function printf($query) {
		$numArgs = func_num_args();
		$args = func_get_args();
		for ($i = 1; $i < $numArgs; $i++) {
			$args[$i] = $this->quoteName($args[$i]);
		}
		$query = call_user_func_array('sprintf', $args);
		return $query;
	}

	public function toDo() {
		return $this->doQuery($this->query, $this->params);
	}

	protected function quoteNameStr($strArr) {
		$parts = array();
		$q = $this->nameQuote;
		foreach ($strArr as $part) {
			if (is_null($part)) {
				continue;
			}
			if (strlen($q) == 1) {
				$parts[] = $q . $part . $q;
			} else {
				$parts[] = $q{0} . $part . $q{1};
			}
		}
		return implode('.', $parts);
	}

	public function quoteName($name, $as = null) {
		if (is_string($name)) {
			$quotedName = $this->quoteNameStr(explode('.', $name));
			$quotedAs = '';
			if (!is_null($as)) {
				settype($as, 'array');
				$quotedAs .= ' AS ' . $this->quoteNameStr($as);
			}
			return $quotedName . $quotedAs;
		} else if (is_numeric($name)) {
			return intval($name);
		} else {
			$fin = array();
			if (is_null($as)) {
				foreach ($name as $str) {
					$fin[] = $this->quoteName($str);
				}
			} elseif (is_array($name) && (count($name) == count($as))) {
				$count = count($name);
				for ($i = 0; $i < $count; $i++) {
					$fin[] = $this->quoteName($name[$i], $as[$i]);
				}
			}
			return $fin;
		}
	}

}
