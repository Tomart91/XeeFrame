<?php

namespace core;

class Dump {

	const limitDepth = 3;
	const PRINT_METHOD = 1 << 0;
	const PRINT_ATTRIBUTES = 1 << 1;
	const PRINT_PROPERTIES = 1 << 2;

	static $config = 0;
	static $color = [
		'key' => 'red',
		'plain' => '#059088',
		'type' => 'blue',
		'method' => '#25ad2a',
		'vars' => '#921e7d',
		'attributes' => 'blue',
	];

	static function isSetFlagConfig($flag) {
		return self::$config & $flag;
	}

	static function getAttributes($object) {
		$atributes = '';
		if ($object->isStatic()) {
			$atributes = 'static ';
		}
		if ($object->isPrivate()) {
			$atributes .= 'private';
		} else if ($object->isProtected()) {
			$atributes .= 'protected';
		} else if ($object->isPublic()) {
			$atributes .= 'public';
		}
		return $atributes;
	}

	static function getFunctionNameByType($type) {
		$functionName = 'print' . ucwords($type);
		if (method_exists(__CLASS__, $functionName)) {
			return $functionName;
		} else {
			return 'printPlainText';
		}
	}

	static function getTab($depth) {
		echo str_repeat('&nbsp;', $depth * 4);
	}

	static function printObject($data, $depth) {
		if (self::limitDepth < $depth) {
			echo '... ';
			return;
		}
		$type = gettype($data);
		echo '<font color="' . self::$color['type'] . '">' . $type . '</font>&nbsp;(';
		echo get_class($data);
		echo ')&nbsp;{<br>';
		$object = new \ReflectionObject($data);
		if (self::isSetFlagConfig(self::PRINT_METHOD)) {
			$methods = $object->getMethods();
			foreach ($methods as $met) {
				self::getTab($depth);
				if (self::isSetFlagConfig(self::PRINT_ATTRIBUTES)) {
					echo '<font color="' . self::$color['attributes'] . '">' . self::getAttributes($met) . '&nbsp;</font>';
				}
				echo '<font color="' . self::$color['method'] . '">' . $met->name . '()</font><br>';
			}
		}
		if (self::isSetFlagConfig(self::PRINT_PROPERTIES)) {
			$vars = $object->getProperties();
			foreach ($vars as $var) {
				self::getTab($depth);
				if (self::isSetFlagConfig(self::PRINT_ATTRIBUTES)) {
					echo '<font color="' . self::$color['attributes'] . '">' . self::getAttributes($var) . '&nbsp;</font>';
				}
				echo "<font color='" . self::$color['key'] . "'>" . $var->name . '</font> = ';
				$var->setAccessible(true);
				$value = $var->getValue($data);
				$type = gettype($value);
				$function = self::getFunctionNameByType($type);
				self::$function($value, $depth + 1);
				echo '<br>';
			}
		}
		echo '<br>';
		self::getTab($depth - 1);
		echo '}';
	}

	static function printBoolean($data, $depth) {
		$type = gettype($data);
		echo '<font color="' . self::$color['type'] . '">' . $type . '</font> &nbsp;';
		echo '<font color="' . self::$color['plain'] . '">' . $data ? 'true' : 'false' . '</font>';
	}

	static function printPlainText($data, $depth) {
		$type = gettype($data);
		echo '<font color="' . self::$color['type'] . '">' . $type . '</font>';
		echo '(' . strlen($data) . ')&nbsp;';
		echo '<font color="' . self::$color['plain'] . '">' . $data . '</font>';
	}

	static function printArray($data, $depth) {
		if (self::limitDepth < $depth) {
			echo '... <br>';
			return;
		}
		$type = gettype($data);
		echo '<font color="' . self::$color['type'] . '">' . $type . '</font>';
		echo '(' . count($data) . ') {<br>';
		foreach ($data as $key => $value) {
			self::getTab($depth);
			echo "['<font color='" . self::$color['key'] . "'>" . $key . '</font>\'] = ';
			$type = gettype($value);
			$function = self::getFunctionNameByType($type);
			self::$function($value, $depth + 1);
			echo '<br>';
		}
		self::getTab($depth - 1);
		echo '}';
	}

	static function printValues($data, $config = 0) {
		if ($config === 0) {
			$config =  self::PRINT_PROPERTIES | self::PRINT_ATTRIBUTES;
		}
		self::$config = $config;
		echo '<div class="well" style="font-size:11px">';
		$type = gettype($data);
		$function = self::getFunctionNameByType($type);
		self::$function($data, 1);
		echo '</div>';
	}

}
