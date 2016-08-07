<?php

namespace modules\Home\controller;

class Index extends \core\controller\ClientController {

	public function process() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Index.twig');
	}

	public function about() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('About.twig');
	}

	public function contact() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Contact.twig');
	}

	public function login() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('Login.twig');
	}

	public function processLogin() {
		$userModel = new \core\auth\BasicUser();
		$error = $userModel->login($this->request->get('login'), $this->request->get('pass'));
		if ($error === true) {
			$this->redirect('/Settings/Home/Index');
		} else {
			$this->redirect('/Home/Index?mode=login&error=' . $error);
		}
	}

}
