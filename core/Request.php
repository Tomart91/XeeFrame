<?php

namespace core;

class Request extends \core\BaseObject {
	
	static public function getInstance() {
		$model = new self();
		$model->setData($_REQUEST);
		return $model;
	}

}
