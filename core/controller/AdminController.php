<?php

namespace core\controller;

use \core\Session;

class AdminController extends BasicController {

	public function checkPermission() {
		Session::startSession();
		Session::checkLogin();
	}

	public function showHeader() {

		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->assign('MODULE_NAME', $this->request->get('moduleName'));
		$viewer->assign('ACTION_NAME', $this->request->get('actionName'));
		$viewer->assign('MODE_NAME', $this->request->get('mode'));
		$viewer->assign('CSS_SCRIPTS', $this->getHeaderCss());
		$viewer->view('SettingsHeader.twig');
	}

	public function showFooter() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->assign('IS_DEBUG', \core\AppConfig::debug('isDebug'));
		$viewer->assign('JS_SCRIPTS', $this->getFooterJs());
		$viewer->assign('TIME_TO_SHOW', microtime(true) - START_TIME);
		$viewer->assign('DEBUG_QUERIES', \core\database\Database::$debugQuery);
		$viewer->assign('ERRORS', \core\XeeException::$errors);
		$viewer->view('SettingsFooter.twig');
	}

	function headerCss() {
		$this->addHeaderCss('/libraries/bootstrap/css/bootstrap.css');
		$this->addHeaderCss('/resources/css/settingsStyle.css');
	}

	function footerJs() {
		$this->addFooterJs('/libraries/jquery/jquery-2.2.3.min.js');
		$this->addFooterJs('/libraries/jquery/jquery.pjax.js');
		$this->addFooterJs('/libraries/bootstrap/js/bootstrap.min.js');
		parent::footerJs();
	}

}
