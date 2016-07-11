<?php

namespace core\controller;

abstract class BasicController {
	public function __construct() {
		$this->headerCss();
		$this->footerJs();
	}
	public $headerCss = [];
	public $footerJs = [];

	function checkPermission() {
		
	}

	function showHeader(\core\Request $request) {
		
	}

	function preProcess(\core\Request $request) {
		
	}

	function process(\core\Request $request) {
		
	}

	function postProcess(\core\Request $request) {
		
	}

	function showFooter(\core\Request $request) {
		
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

}
