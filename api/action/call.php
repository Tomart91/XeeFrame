<?php

namespace api\action;

/**
 * Action to clickToCall
 */
class call extends \api\core\BaseAction {

	/**
	 *
	 * @var <string> Require method 
	 */
	public $requireMethod = 'POST';

	/**
	 *
	 * @var <Array> Require data
	 */
	public $requireData = ['destNumber', 'srcNumber'];

	/**
	 * Action
	 * @param <\core\Request> $request 
	 * @return <Array> 
	 * @throws <\core\ApiException>
	 */
	function process($request) {
		$userName = 'admin';
		$password = 'admin';
		$timeout = 10;
		$wrets = '';

		$socket = @fsockopen("178.42.163.141", "5038", $errno, $errstr, $timeout);
		if (!$socket) {
			throw \core\ApiException::getInstance(500, 'UNABLE_CONNECTING' . $errstr);
		} else {
			$destNumber = $request->get('destNumber');
			$srcNumber = $request->get('srcNumber');
			fputs($socket, "Action: Login\r\n");
			fputs($socket, "UserName: $userName\r\n");
			fputs($socket, "Secret: $password\r\n");
			fputs($socket, "events: on\r\n\r\n");


			fputs($socket, "Action: Originate\r\n");
			fputs($socket, "Channel: $srcNumber\r\n");
			fputs($socket, "Context: internal\r\n");
			fputs($socket, "Exten: $destNumber\r\n");
			fputs($socket, "Priority: 1\r\n\r\n");

			fputs($socket, "Action: Logoff\r\n\r\n");
			while (!feof($socket)) {
				$wrets .= fread($socket, 10000);
			}
		}
		fclose($socket);
		$response = explode(PHP_EOL, $wrets);
		return ['count' => $response];
	}

}
