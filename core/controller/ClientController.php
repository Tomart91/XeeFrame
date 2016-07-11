<?php

namespace core\controller;

class ClientController extends BasicController {

	public function showHeader(\core\Request $request) {
		$viewer = \core\Viewer::getInstance($request);
		$viewer->assign('CSS_SCRIPTS', $this->getHeaderCss());
		$viewer->view('Header.tpl');
	}

	public function showFooter(\core\Request $request) {
		$viewer = \core\Viewer::getInstance($request);
		$viewer->assign('JS_SCRIPTS', $this->getFooterJs());
		$viewer->view('Footer.tpl');
	}

	function headerCss() {
		$this->addHeaderCss('libraries/bootstrap/css/bootstrap.css');
		$this->addHeaderCss('resources/css/font-awesome.css');
		$this->addHeaderCss('resources/css/grayscale.css');
	}

	function footerJs() {
		$this->addFooterJs('libraries/jquery/jquery-2.2.3.js');
		$this->addFooterJs('libraries/bootstrap/js/bootstrap.js');
		$this->addFooterJs('http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js');
		$this->addFooterJs('https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false');
		$this->addFooterJs('resources/js/grayscale.js');
	}

}
