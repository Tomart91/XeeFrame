<?php

namespace modules\Home\controller;

class Index extends \core\controller\ClientController {

	public function process() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Index.twig');
	}
	public function about(){
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('About.twig');
	}
	public function contact(){
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Contact.twig');
	}
}
