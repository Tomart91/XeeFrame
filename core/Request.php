<?php

namespace core;

class Request extends \core\BaseObject {

	static public function getInstance() {
		$model = new self();
		$model->setData($_REQUEST);
		return $model;
	}

	public function getModule() {
		return $this->get('moduleName');
	}

	public static function isAjax() {
		if (!empty($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == true) {
			return true;
		} elseif (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
		return false;
	}

}
