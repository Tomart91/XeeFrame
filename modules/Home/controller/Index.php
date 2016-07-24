<?php

namespace modules\Home\controller;

class Index extends \core\controller\ClientController {

	public function process() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Index.twig');
	}

}
