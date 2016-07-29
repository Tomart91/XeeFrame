<?php

$startTime = microtime(true);
require 'AutoLoader.php';
define('ROOT_DIR', __DIR__);
define('START_TIME', $startTime);
if (\core\AppConfig::get('isDebug')) {
	set_error_handler(['\core\XeeException', 'errorHandler']);
	register_shutdown_function(['\core\XeeException', 'fatalErrorHandler']);
}
$request = core\Request::getInstance();
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
core\Language::$defaultModule = $moduleName;
$moduleName = ucwords($moduleName);
$action = ucwords($action);
$controllerName = '\modules\\' . $moduleName . '\\controller\\' . $action;

$controllerObject = new $controllerName($request);
try {
	$controllerObject->checkPermission();
	if (!core\Request::isAjax()) {
		$controllerObject->showHeader();
		$controllerObject->preProcess();
	}
	if ($request->has('mode')) {
		$mode = $request->get('mode');
		if(method_exists($controllerObject, $mode)){
			$controllerObject->$mode();
		}
	} else {
		$controllerObject->process();
	}
	if (!core\Request::isAjax()) {
		$controllerObject->postProcess();
		$controllerObject->showFooter();
	}
} catch (Exception $ex) {
	$controllerObject->redirect('/Home/Index');
}

