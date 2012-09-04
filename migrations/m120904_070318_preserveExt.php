<?php

class m120904_070318_preserveExt extends EDbMigration
{
	public function up()
	{
        $this->addColumn("{{held_image}}", "ext", "ENUM('jpg', 'png', 'gif') DEFAULT 'jpg'");
	}

	public function down()
	{
		echo "m120904_070318_preserveExt does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}