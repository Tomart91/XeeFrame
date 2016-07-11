<?php

namespace core;

class Viewer {
	static function getInstance(\core\Request $request){
		$model = new self();
		return $model;
	}
	public function view($file = ''){
		
	}
}
