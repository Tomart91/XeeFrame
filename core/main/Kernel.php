<?php

namespace core\main;

class Kernel {

	private static function registerAutoloader() {
		require_once ROOT_DIR . '/core/autoloader/autoload_real.php';
		\ComposerAutoloaderInit::getLoader();
		\Twig_Autoloader::register();
	}

	static public function init() {
		self::registerAutoloader();
		if (\core\AppConfig::debug('isDebug')) {
			set_error_handler(['\core\XeeException', 'errorHandler']);
			register_shutdown_function(['\core\XeeException', 'fatalErrorHandler']);
		}
		$request = \core\Request::getInstance();
		\core\database\Database::connect();

		$controller = $request->get('control');
		$controller = explode('/', $controller);
		$moduleName = $controller[0];

		if (empty($moduleName)) {
			$moduleName = 'Home';
		}
		if (empty($controller[1])) {
			$action = 'Index';
		} else {
			$action = $controller[1];
		}
		$request->set('moduleName', $moduleName);
		$request->set('actionName', $action);
		\core\Language::$defaultModule = $moduleName;
		$moduleName = ucwords($moduleName);
		$action = ucwords($action);
		if ($moduleName == 'Settings') {
			$controllerName = '\modules\\' . $moduleName . '\\' . $action . '\\controller\\' . $controller[2];
			$request->set('moduleName', $moduleName . '\\' . $action);
			$request->set('actionName', $controller[2]);
		} else {
			$controllerName = '\modules\\' . $moduleName . '\\controller\\' . $action;
		}

		if (class_exists($controllerName)) {
			$controllerObject = new $controllerName($request);
			try {
				$controllerObject->checkPermission();
				if (!\core\Request::isAjax()) {
					$controllerObject->showHeader();
					$controllerObject->preProcess();
				} else {
					$controllerObject->preProcessAjax();
				}
				if ($request->has('mode')) {
					$mode = $request->get('mode');
					if (method_exists($controllerObject, $mode)) {
						$controllerObject->$mode();
					}
				} else {
					$controllerObject->process();
				}
				if (!\core\Request::isAjax()) {
					$controllerObject->postProcess();
					$controllerObject->showFooter();
				} else {
					$controllerObject->postProcessAjax();
				}
			} catch (Exception $ex) {
				$controllerObject->redirect('/Home/Index');
			}
		} else {
			http_response_code(404);
		}
	}

}
