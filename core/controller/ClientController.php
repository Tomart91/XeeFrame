<?php

namespace core\controller;

class ClientController extends BasicController {
	public function showHeader(\core\Request $request) {
		$viewer = \core\Viewer::getInstance($request);
		$viewer->view('Header.tpl');
	}
	public function showFooter(\core\Request $request) {
		$viewer = \core\Viewer::getInstance($request);
		$viewer->view('Footer.tpl');
	}
}
