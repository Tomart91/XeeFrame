<?php

namespace modules\Settings\Slider\controller;

use \core\database\Database;

class DeleteImage extends \core\controller\AdminController {

	public function process() {
		$db = Database::getInstance();
		$db->delete()->from('cms_slider')->where('id = ?', [$this->request->get('id')])->toDo();
		$data = ['succes' => true];
		$response = \core\Response::getInstance();
		$response->setData($data);
		$response->emit();
	}

}
