<?php

namespace modules\Home\controller;

use \core\database\Database;

class Index extends \core\controller\ClientController {

	public function process(\core\Request $request) {
		$db = Database::getInstance();
		$result = $db->select(['username', 'pass'])->from('users')->where('id = ?', [1])->orderBy('id', 'ASC')->limit(1)->toDo();
				$result = $db->select(['username', 'pass'])->from('users')->where('id = ?', [1])->orderBy('id', 'ASC')->limit(1)->toDo();
		$viewer = \core\Viewer::getInstance($request);
		$viewer->view('Index.twig');
	}

}
