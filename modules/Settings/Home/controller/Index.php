<?php

namespace modules\Settings\Home\controller;

class Index extends \core\controller\AdminController {

	public function process() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Index.twig');
	}

}
