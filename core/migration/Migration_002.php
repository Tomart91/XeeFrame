<?php

namespace core\migration;

use core\database\Schema;

class Migration_002 {

	public static function add(Schema $schema) {
		$table = $schema->createTable('cms_slider');
		$table->addColumn()->int('id')->length(11)->notNull()->primaryKey()->unsigned()->autoIncrement();
		$table->addColumn()->string('image')->length(255);
		$schema->create();
		$schema->insert('cms_slider', ['image' => '/storage/modules/Home/55446842dbb4d_2560x1600.jpg']);
	}

	public static function remove(Schema $schema) {
		$schema->dropTable('cms_slider');
	}

}
