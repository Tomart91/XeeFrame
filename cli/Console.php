<?php

namespace cli;

class Console extends \core\BaseObject {

	public $argc = false;
	public $argv = [];

	function initialize() {
		$arguments = [];
		foreach ($this->argv as $variable) {
			if (strpos($variable, '-') !== false) {
				$variable = str_replace('-', '', $variable);
				$this->set('action', $variable);
			}
			if (strpos($variable, ':') !== false) {
				$variable = str_replace(':', '', $variable);
				$arguments [] = $variable;
			}
			if (strpos($variable, '$') !== false) {
				$variable = str_replace('$', '', $variable);
				$this->set('class', $variable);
			}
		}
		$this->set('arguments', $arguments);
	}

	static function getInstance($argc, $argv) {
		$instance = new self();
		$instance->argc = $argc;
		$instance->argv = $argv;
		return $instance;
	}

	public function handle() {
		$this->initialize();
		$class = $this->get('class');
		$action = $this->get('action');
		$arg = $this->get('arguments');
		$data = call_user_func_array(__NAMESPACE__ . "\\$class::$action", $arg);
		$response = \core\Response::getInstance();
		$response->setData($data);
		$response->emitType(\core\Response::CLI);
		$response->emit();
	}

}
