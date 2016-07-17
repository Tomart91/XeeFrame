<?php
$startTime = microtime(true);
require 'AutoLoader.php';
define('ROOT_DIR', __DIR__);
define('START_TIME', $startTime);
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

$controllerObject = new $controllerName();
$controllerObject->checkPermission();
$controllerObject->showHeader($request);
$controllerObject->preProcess($request);
$controllerObject->process($request);
$controllerObject->postProcess($request);
$controllerObject->showFooter($request);
