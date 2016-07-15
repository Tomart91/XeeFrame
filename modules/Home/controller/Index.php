<?php

namespace modules\Home\controller;

class Index extends \core\controller\ClientController {

	public function process(\core\Request $request) {
		$viewer = \core\Viewer::getInstance($request);
		$viewer->view('Index.tpl');
	}

}
