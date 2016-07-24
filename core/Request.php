<?php

namespace core;

class Request extends \core\BaseObject {

	public $purifier = false;

	public function init() {
		require_once '/libraries/htmlPurifier/HTMLPurifier.auto.php';
		$use_charset = 'UTF-8';
		$allowed = array(
			'img[src|alt|title|width|height|style|data-mce-src|data-mce-json]',
			'figure', 'figcaption',
			'video[src|type|width|height|poster|preload|controls|style|class]', 'source[src|type]',
			'audio[src|type|preload|controls]',
			'a[href|target|style]',
			'iframe[width|height|src|frameborder|allowfullscreen]',
			'strong', 'b', 'i', 'u', 'em', 'br', 'font',
			'h1[style]', 'h2[style]', 'h3[style]', 'h4[style]', 'h5[style]', 'h6[style]',
			'p[style]', 'div[style]', 'center', 'address[style]',
			'span[style]', 'pre[style]',
			'ul', 'ol', 'li',
			'table[width|height|border|style|class|cellpadding|cellspacing|align|bgcolor]',
			'th[width|height|border|style]',
			'tr[width|height|border|style]',
			'td[rowspan|width|height|border|style|bgcolor]',
			'hr',
			'div[class]',
			'button[style]'
		);
		$config = \HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', $use_charset);
		$config->set('URI.MakeAbsolute', true);
		$config->set('URI.AllowedSchemes', array('data' => true));
		$config->set('Core.RemoveInvalidImg', true);
		$config->set('Cache.SerializerPath', ROOT_DIR . '/cache/aelib');
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
		$config->set('CSS.AllowTricky', true);
		$config->set('HTML.SafeIframe', true);
		$config->set('HTML.SafeEmbed', true);
		$config->set('URI.SafeIframeRegexp', '%^(http:|https:)?//(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%');
		$config->set('HTML.Allowed', implode(',', $allowed));
		$config->set('HTML.DefinitionID', 'html5-definitions'); // unqiue id
		$config->set('HTML.DefinitionRev', 1);
		$this->purifier = new \HTMLPurifier($config);
	}

	static public function getInstance() {
		$model = new self();
		$model->init();
		$model->setData($_REQUEST);
		return $model;
	}

	public function getModule() {
		return $this->get('moduleName');
	}

	public static function isAjax() {
		if (!empty($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] === true) {
			return true;
		} elseif (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
		return false;
	}

	private function clean($array = []) {
		if (is_array($array)) {
			foreach ($array as $key => &$req) {
				if (is_array($req)) {
					$req = $this->clean($req);
				} else {
					$req = $this->purifier->purify($req);
				}
			}
		} else {
			$array = $this->purifier->purify($array);
		}
		return $array;
	}

	public function get($key) {
		static $valueMap = [];
		if (isset($valueMap[$key])) {
			return $valueMap[$key];
		}
		$rawData = parent::get($key);
		$cleanData = $this->clean($rawData);
		$valueMap[$key] = $cleanData;
		return $cleanData;
	}

}
