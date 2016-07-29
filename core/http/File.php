<?php

namespace core\http;

class File {

	private $pathToSave = ROOT_DIR . '/storage/';
	public $file = [];
	public $wrongExtension = [];
	public $allowedImageFormats = ['jpeg', 'png', 'jpg', 'pjpeg', 'x-png', 'gif', 'bmp'];
	public $mimeType = [];

	public function getMimeContentType() {
		require 'core/config/mimetypes.php';
		$filename = $this->file['tmp_name'];
		$fileNameDevided = explode('.', $filename);
		$ext = strtolower(end($fileNameDevided));
		if (isset($mimeTypes[$ext])) {
			$fileMimeContentType = $mimeTypes[$ext];
		} elseif (function_exists('mime_content_type')) {
			$fileMimeContentType = mime_content_type($filename);
		} elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$fileMimeContentType = finfo_file($finfo, $filename);
			finfo_close($finfo);
		} else {
			$fileMimeContentType = 'application/octet-stream';
		}
		$result['mimeType'] = $fileMimeContentType;
		$fileMimeContentTypeArray = explode('/', $fileMimeContentType);
		$result['type'] = $fileMimeContentTypeArray[0];
		$result['extension'] = $fileMimeContentTypeArray[1];
		return $result;
	}

	function validateCodeInjection() {
		$imageContents = file_get_contents($this->file['tmp_name']);
		if (preg_match('/(<\?php?(.*?))/i', $imageContents) == 1) {
			throw new \core\XeeException;
		}
	}

	public function validate() {
		$this->validAllowedExtensions();
		$this->validateCodeInjection();
	}

	public function validAllowedExtensions() {
		$fileType = $this->mimeType['extension'];
		$fileType = strtolower($fileType);
		if (!in_array($fileType, $this->allowedImageFormats)) {
			throw new \core\XeeException;
		}
	}

	public function validateImage() {
		$this->validate();
	}

	/** Function to sanitize the upload file name when the file name is detected to have bad extensions
	 * @param String -- $fileName - File name to be sanitized
	 * @return String - Sanitized file name
	 */
	public static function sanitizeUploadFileName($fileName, $wrongExtension) {
		//$fileName = vtlib\Functions::slug($fileName);
		$fileName = rtrim($fileName, '\\/<>?*:"<>|');
		$fileNameParts = explode(".", $fileName);
		$badExtensionFound = false;
		foreach ($fileNameParts as $partOfFileName) {
			if (in_array(strtolower($partOfFileName), $wrongExtension)) {
				$badExtensionFound = true;
				$fileNameParts[$i] = $partOfFileName . 'file';
			}
		}
		$newFileName = implode(".", $fileNameParts);
		if ($badExtensionFound) {
			$newFileName .= ".txt";
		}
		return $newFileName;
	}

	/**
	 * 
	 * @param <array> $files This is array $_FILES
	 */
	public static function getInstance($file) {
		$instance = new self();
		$instance->file = $file;
		return $instance;
	}

	/**
	 * Function to save file
	 */
	public function save() {
		if (isset($this->file['original_name']) && $this->file['original_name'] != null) {
			$fileName = $this->file['original_name'];
		} else {
			$fileName = $this->file['name'];
		}
		$this->mimeType = $this->getMimeContentType();
		if ($this->mimeType['mimeType'] != $this->file['type']) {
			return false;
		}
		$validateFunctionName = 'validate' . ucwords($this->mimeType['type']);
		try {
			if (method_exists($this, $validateFunctionName)) {
				$this->$validateFunctionName();
			} else {
				$this->validate();
			}
		} catch (\core\XeeException $ex) {
			return false;
		}
		$fileName = $this->sanitizeUploadFileName($fileName, $this->wrongExtension);
		$fileName = ltrim(basename(' ' . $fileName));
		$uploadStatus = move_uploaded_file($this->file['tmp_name'], $this->pathToSave . '/' . $fileName);
		return $uploadStatus;
	}

	public function setAllowedExtensions($type) {
		$this->allowedImageFormats = $type;
	}

	/**
	 * Set not allowed extensions
	 */
	public function setWrongExtensions() {
		$this->wrongExtension = ['php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp',
			'cfm', 'js', 'vbs', 'html', 'htm', 'exe', 'bin', 'bat', 'sh', 'dll', 'phps',
			'phtml', 'xhtml', 'rb', 'msi', 'jsp', 'shtml', 'sth', 'shtm'];
	}

}