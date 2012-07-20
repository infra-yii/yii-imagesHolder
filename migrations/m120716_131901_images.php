<?php

class m120716_131901_images extends CDbMigration
{
    public function up()
    {
        $this->createTable("{{images_holder}}", array(
            "id" => "pk"
        ));
        $this->createTable("{{image}}", array(
            "id" => "pk",
            "title" => "VARCHAR(255) not null",
            "holder_id" => "int"
        ));
        $this->addForeignKey("image_holder", "{{image}}", "holder_id", "{{images_holder}}", "id");
    }

    public function down()
    {
        $this->dropTable("{{image}}");
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