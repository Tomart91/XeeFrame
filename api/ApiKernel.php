<?php

namespace api;

class ApiKernel {

	static function init($action) {
		$request = \core\Request::getInstance();
		$response = \core\Response::getInstance();
		$data = [];
		try {
			$actionName = '\\api\\action\\';
			$actionName .= $action;
			if (class_exists($actionName)) {
				$actionModel = new $actionName();
				$actionModel->checkPermission($request);
				$data = $actionModel->process($request);
				$data['success'] = true;
			} else {
				throw \api\core\ApiException::getInstance(500, 'ACTION_NOT_FOUND');
			}
		} catch (\api\core\ApiException $ex) {
			$data['success'] = false;
			$data['error'] = $ex->getMessage();
			http_response_code($ex->getCode());
		}
		$response->setData($data);
		$response->emit();
	}

}
