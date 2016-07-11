<?php

namespace core;

class Viewer {

	public $smarty;
	public $path;

	static function getInstance(\core\Request $request) {
		$model = new self();
		require_once('libraries/smarty/Smarty.class.php');
		$model->smarty = new \Smarty();
		$model->smarty->setTemplateDir('/cache/smarty/templates');
		$model->smarty->setCompileDir('/cache/smarty/templates_c');
		$model->smarty->setCacheDir('/cache/smarty/cache');
		$model->smarty->setConfigDir('/cache/smarty/configs');
		$model->path = 'modules/' . $request->getModule() . '/view';
		return $model;
	}

	public function view($file = '') {
		$filePath = $this->path . '/' . $file;
		if (!file_exists($filePath)) {
			$filePath = 'view/' . $file;
		}
		$this->smarty->display($filePath);
	}

}
