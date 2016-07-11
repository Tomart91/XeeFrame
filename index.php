<?php

require 'AutoLoader.php';
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
$request = core\Request::getInstance();

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
