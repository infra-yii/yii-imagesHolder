<?php

class m120716_132747_images_holder_type extends CDbMigration
{
    public function up()
    {
        $this->addColumn("{{images_holder}}", "type", "varchar(16) not null");
    }

    public function down()
    {
        echo "m120716_132747_images_holder_type does not support migration down.\n";
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