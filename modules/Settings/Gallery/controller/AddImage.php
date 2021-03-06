<?php

namespace modules\Settings\Gallery\controller;

use \core\database\Database;

class AddImage extends \core\controller\AdminController {

	public function process() {
		$fileValidator = \core\http\File::getInstance($_FILES['image']);
		$fileValidator->setPath(ROOT_DIR . '/storage/modules/Home');
		$fileName = $fileValidator->save();
		$data = [];
		if ($fileName !== false) {
			$fileName = str_replace(ROOT_DIR, '', $fileName);
			$data['success'] = true;
			$data['fileName'] = $fileName;
			$db = Database::getInstance();
			$db->insert('cms_gallery', ['image' => $fileName]);
		} else {
			$data['success'] = false;
		}
		$response = \core\Response::getInstance();
		$response->setData($data);
		$response->emit();
	}

}
