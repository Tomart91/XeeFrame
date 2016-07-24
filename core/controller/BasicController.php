<?php

namespace core\controller;

abstract class BasicController {

	public function __construct(\core\Request $request) {
		$this->request = $request;
		$this->headerCss();
		$this->footerJs();
		$this->addFooterJs('resources/js/app.js');
	}

	public $request = false;
	public $headerCss = [];
	public $footerJs = [];

	function checkPermission() {
		
	}

	function showHeader() {
		
	}

	function preProcess() {
		
	}

	function process() {
		
	}

	function postProcess() {
		
	}

	function showFooter() {
		
	}

	function addHeaderCss($file) {
		$this->headerCss[] = $file;
	}

	function addFooterJs($file) {
		$this->footerJs[] = $file;
	}

	function getHeaderCss() {
		return $this->headerCss;
	}

	function getFooterJs() {
		return $this->footerJs;
	}

	function footerJs() {
		$this->addFooterJs('modules/' . $this->request->get('moduleName') . '/js/' . $this->request->get('actionName') . '.js');
	}

}
