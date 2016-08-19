<?php

namespace core;

class WriterFile {

	public $path = '';
	public $fileContent = '';

	public static function getInstance() {
		return new self();
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function fileToReturn($data) {
		$this->fileContent = '<?php' . PHP_EOL;
		$this->fileContent .= 'return ' . $data . ';';
	}

	public function save() {
		file_put_contents(ROOT_DIR . $this->path, $this->fileContent);
	}

}
