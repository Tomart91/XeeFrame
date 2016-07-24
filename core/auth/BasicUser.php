<?php

namespace core\auth;

use core\database\Database;
use \core\Session;

class BasicUser {

	public $tableName = 'users';
	// columns
	public $login = 'email';
	public $password = 'pass';
	public $page = '/Home/Login';
	public $startPage = '/Settings/Start';

	public function register($login, $rawPass) {
		$db = Database::getInstance();
		$result = $db->select(['*'])->from($this->tableName)->where($this->login . ' = ?', [$login])->toDo();
		if ($result->isExists()) {
			return 'LBL_EMAIL_IS_EXISTS';
		} else {
			$hashPass = hash('sha512', $rawPass);
			$hashPass = hash('sha512', $hashPass . \core\AppConfig::get('salt'));
			$db->insert($this->tableName, [
				$this->login => $login,
				$this->password => $hashPass
			])->toDo();
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			Session::startSession();
			Session::set('login', $login);
			Session::set('loginVerify', hash('sha512', $userAgent . $hashPass . $login));
			return true;
		}
	}

	public function login($login, $rawPass) {
		$db = Database::getInstance();
		$result = $db->select(['*'])->from($this->tableName)->where($this->login . ' = ?', [$login])->toDo();
		if ($result->isExists()) {
			$userRow = $result->getRow();
			$hashPass = hash('sha512', $rawPass);
			$hashPass = hash('sha512', $hashPass . \core\AppConfig::get('salt'));
			if ($userRow[$this->password] == $hashPass) {
				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				Session::startSession();
				Session::set('login', $login);
				Session::set('loginVerify', hash('sha512', $userAgent . $hashPass . $login));
				return true;
			} else {
				return 'LBL_NO_PASSWORD_OR_LOGIN';
			}
		} else {
			return 'LBL_NO_PASSWORD_OR_LOGIN';
		}
	}
	public function checkLogin() {
		$login = Session::get('login');
		$db = Database::getInstance();
		$result = $db->select(['*'])->from($this->tableName)->where($this->login . ' = ?', [$login])->toDo();
		if ($result->isExists()) {
			$userRow = $result->getRow();
			$rawPass = $userRow[$this->password];
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			$loginVerify = hash('sha512', $userAgent . $rawPass . $login);
			if ($loginVerify == Session::get('loginVerify')) {
				return true;
			} else {
				throw new \core\XeeException('WRONG AUTHORIZATION');
			}
		} else {
			throw new \core\XeeException('WRONG AUTHORIZATION');
		}
	}
}
