<?php

class m120716_131901_images extends CDbMigration
{
    public function up()
    {
        $this->createTable("{{images_holder}}", array(
            "id" => "pk",
            "type" => "varchar(16) not null"
        ));
        $this->createTable("{{held_image}}", array(
            "id" => "pk",
            "title" => "VARCHAR(255) not null",
            "holder_id" => "int"
        ));
        $this->addForeignKey("image_holder", "{{held_image}}", "holder_id", "{{images_holder}}", "id");
    }

    public function down()
    {
        $this->dropTable("{{held_image}}");
        $this->dropTable("{{images_holder}}");
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