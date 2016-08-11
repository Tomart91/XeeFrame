<?php

namespace core\controller;

class ClientController extends BasicController {

	public function showHeader() {

		$db = \core\database\Database::getInstance();
		$result = $db->select(['*'])->from('cms_menu')->toDo();
		$menu = [];
		while ($row = $result->getRow()) {
			$menu [] = $row;
		}
		$result = $db->select(['*'])->from('cms_slider')->toDo();
		$slider = [];
		while ($row = $result->getRow()) {
			$slider [] = $row;
		}
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->assign('MODULE_NAME', $this->request->get('moduleName'));
		$viewer->assign('ACTION_NAME', $this->request->get('actionName'));
		$viewer->assign('MODE_NAME', $this->request->get('mode'));
		$viewer->assign('MENUS', $menu);
		$viewer->assign('SLIDERS', $slider);
		$viewer->assign('CSS_SCRIPTS', $this->getHeaderCss());
		$viewer->assign('', $this->getHeaderCss());
		$viewer->view('Header.twig');
	}

	public function showFooter() {
		$viewer = \core\Viewer::getInstance($this->request);
		$viewer->assign('IS_DEBUG', \core\AppConfig::debug('isDebug'));
		$viewer->assign('JS_SCRIPTS', $this->getFooterJs());
		$viewer->assign('TIME_TO_SHOW', microtime(true) - START_TIME);
		$viewer->assign('DEBUG_QUERIES', \core\database\Database::$debugQuery);
		$viewer->assign('ERRORS', \core\XeeException::$errors);
		$viewer->view('Footer.twig');
	}

	function headerCss() {
		$this->addHeaderCss('/libraries/bootstrap/css/bootstrap.css');
		$this->addHeaderCss('/resources/css/style.css');
	}

	function footerJs() {
		$this->addFooterJs('/libraries/jquery/jquery-2.2.3.min.js');
		$this->addFooterJs('/libraries/jquery/jquery.pjax.js');
		$this->addFooterJs('/libraries/bootstrap/js/bootstrap.min.js');
		$this->addFooterJs('/resources/js/layout.js');
		parent::footerJs();
	}

}
