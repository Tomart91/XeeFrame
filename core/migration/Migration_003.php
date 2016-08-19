<?php

namespace core\migration;

use core\database\Schema;

class Migration_003 {

	public static function add(Schema $schema) {
		$table = $schema->createTable('cms_menu');
		$table->addColumn()->int('id')->length(11)->notNull()->primaryKey()->unsigned()->autoIncrement();
		$table->addColumn()->string('label')->length(50);
		$table->addColumn()->string('link')->length(255);
		$table->addColumn()->string('icon')->length(255);
		$schema->create();
		$params = [
			'label' => 'LBL_HOME',
			'link' => '/Home/Index',
			'icon' => 'glyphicon glyphicon-home'
		];
		$schema->insert('cms_menu', $params);
		$params = [
			'label' => 'LBL_ABOUT_ME',
			'link' => '/Home/Index?mode=about',
			'icon' => 'glyphicon glyphicon-user'
		];
		$schema->insert('cms_menu', $params);
		$params = [
			'label' => 'LBL_GALLERY',
			'link' => '/Home/Index?mode=categoriesGallery',
			'icon' => 'glyphicon glyphicon-camera'
		];
		$schema->insert('cms_menu', $params);
		$params = [
			'label' => 'LBL_APP',
			'link' => '/Home/Index?mode=app',
			'icon' => 'glyphicon glyphicon-floppy-disk'
		];
		$schema->insert('cms_menu', $params);
		$params = [
			'label' => 'LBL_CONTACT',
			'link' => '/Home/Index?mode=contact',
			'icon' => 'glyphicon glyphicon-phone-alt'
		];
		$schema->insert('cms_menu', $params);
		$params = [
			'label' => 'LBL_LOGIN',
			'link' => '/Home/Index?mode=login',
			'icon' => 'glyphicon glyphicon-phone-alt'
		];
		$schema->insert('cms_menu', $params);
	}

	public static function remove(Schema $schema) {
		$schema->dropTable('cms_menu');
	}

}
