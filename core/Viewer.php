<?php

namespace core;

class Viewer {

	public $path;
	public $variable = [];

	static function getInstance(\core\Request $request) {
		$model = new self();
		$model->path = ROOT_DIR . '/modules/' . $request->getModule() . '/view';
		return $model;
	}

	public function assign($key, $value) {
		$this->variable[$key] = $value;
	}

	public function view($file = '') {
		$filePath = $this->path . '/' . $file;
		if (!file_exists($filePath)) {
			$filePath = ROOT_DIR . '/view/' . $file;
			$this->path = ROOT_DIR . '/view/';
		}
		$loader = new \Twig_Loader_Filesystem($this->path);
		$twig = new \Twig_Environment($loader, [
			//'cache' => ROOT_DIR . '/cache/twig/cache',
			'strict_variables' => true
		]);
		$twig->addGlobal('Lang', new \core\Language());
		echo $twig->render($file, $this->variable);
	}

}
