<?php

namespace core;

class Viewer {

	public $smarty;
	public $path;

	static function getInstance(\core\Request $request) {
		$model = new self();
		require_once('libraries/smarty/Smarty.class.php');
		$model->smarty = new \Smarty();
		$model->smarty->setTemplateDir(ROOT_DIR . '/cache/smarty/templates');
		$model->smarty->setCompileDir(ROOT_DIR . '/cache/smarty/templates_c');
		$model->smarty->setCacheDir(ROOT_DIR . '/cache/smarty/cache');
		$model->smarty->setConfigDir(ROOT_DIR . '/cache/smarty/configs');
		$model->path = 'modules/' . $request->getModule() . '/view';
		return $model;
	}
	public function assign($key, $value){
		$this->smarty->assign($key, $value);
	}
	public function view($file = '') {
		$filePath = $this->path . '/' . $file;
		if (!file_exists($filePath)) {
			$filePath = 'view/' . $file;
		}
		$this->smarty->display($filePath);
	}

}
