<?php

namespace core\migration;

use core\database\Schema;

class Migration_001 {

	public static function add(Schema $schema) {
		$table = $schema->createTable('users');
		$table->addColumn()->int('id')->length(11)->notNull()->primaryKey()->unsigned()->autoIncrement();
		$table->addColumn()->string('email')->length(100);
		$table->addColumn()->text('pass')->length(100);
		$schema->create();
		
		$schema->insert('users', ['email' => 'tomek.kur14@op.pl', 'pass' => '743bd635fe1bb6bd3aff31971d999a06b08c31d04246a8df80226ce895f7f33ba9b1a7d8dc6573b44dbf3d7492f5a80b2ebfaeea0a128f2cb777e07a455a4bd9']);
	}

	public static function remove(Schema $schema) {
		$schema->dropTable('users');
	}

}
