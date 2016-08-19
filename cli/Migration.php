<?php

namespace cli;

use \core\database\Schema;

class Migration {

	private static function saveVersion($version) {
		$writer = \core\WriterFile::getInstance();
		$writer->setPath('/core/migration.php');
		$writer->fileToReturn($version);
		$writer->save();
	}

	public static function add() {
		$response = [];
		$actualVersion = \core\App::getVersion();
		$migrationVersion = (float) \core\App::getMigrationVersion();
		if ($actualVersion > $migrationVersion) {
			Schema::connect();
			$schema = Schema::getInstance();
			$namespace = 'core\\migration\\';
			for ($i = $migrationVersion; $i <= $actualVersion; $i += 0.01) {
				$className = (String) $i;
				$className = str_replace('.', '', $className);
				$className = $namespace . 'Migration_' . $className;
				if (class_exists($className)) {
					$response [] = $className;
					$className::add($schema);
				}
			}
			self::saveVersion($actualVersion);
			return $response;
		} else {
			return 'No migration';
		}
	}

	public static function remove() {
		$response = [];
		$actualVersion = \core\App::getVersion();
		$migrationVersion = (float) \core\App::getMigrationVersion();
		if ($actualVersion < $migrationVersion) {
			Schema::connect();
			$schema = Schema::getInstance();
			$namespace = 'core\\migration\\';
			for ($i = $migrationVersion; $i >= $actualVersion; $i -= 0.01) {
				$className = (String) number_format($i, 2);
				$className = str_replace('.', '', $className);
				$className = $namespace . 'Migration_' . $className;
				if (class_exists($className)) {
					$response [] = $className;
					$className::remove($schema);
				}
			}
			self::saveVersion($actualVersion);
			return $response;
		} else {
			return 'No migration';
		}
	}

}
