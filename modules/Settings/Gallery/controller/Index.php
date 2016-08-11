<?php

namespace modules\Settings\Gallery\controller;
use core\database\Database;
class Index extends \core\controller\AdminController {

	public function process() {
		$db = Database::getInstance();
		$result = $db->select(['*'])->from('cms_gallery')->toDo();
		$images = [];
		while($row = $result->getRow()){
			$images[$row['id']] = $row;
		}
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->assign('IMAGES', $images);
		$viewer->view('Index.twig');
	}

}
