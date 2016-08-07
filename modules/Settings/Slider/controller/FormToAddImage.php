<?php

namespace modules\Settings\Slider\controller;

class FormToAddImage extends \core\controller\ModalAdminController {

	public function process() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->view('FormToAddImage.twig');
	}

}
