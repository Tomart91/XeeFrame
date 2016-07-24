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
$controller = explode('//', $controller);
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
$moduleName = ucwords($moduleName);
$action = ucwords($action);
$controllerName = '\modules\\' . $moduleName . '\\controller\\' . $action;

$controllerObject = new $controllerName($request);

$controllerObject->checkPermission();
$controllerObject->showHeader();
$controllerObject->preProcess();
if ($request->has('mode')) {
	$mode = $request->get('mode');
	$controllerObject->$mode();
} else {
	$controllerObject->process();
}
$controllerObject->postProcess();
$controllerObject->showFooter();
