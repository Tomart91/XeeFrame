<?php

namespace api\core;

class Debug {

	static function registerToFile(\core\Request $request, $response) {
		$file = 'cache/logs/apiRequest.log';
		$content = '=============== ' . date('Y-m-d H:i:s') . ' =================' . PHP_EOL;
		$content .= '================ REQUEST ================' . PHP_EOL;
		foreach ($request->getData() as $key => $req) {
			$content .= '[' . $key . '] = ' . (string) $req . PHP_EOL;
		}
		$content .= '================ RESPONSE ================' . PHP_EOL;
		foreach ($response as $key => $req) {
			$content .= '[' . $key . '] = ' . (string) $req . PHP_EOL;
		}
		file_put_contents($file, $content, FILE_APPEND);
	}

}
