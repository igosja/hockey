<?php

class m161021_111251_namecountry extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{namecountry}}', array(
            'namecountry_id' => 'pk',
            'namecountry_country_id' => 'INT(11) DEFAULT 0',
            'namecountry_name_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('namecountry_country_id', '{{namecountry}}', 'namecountry_country_id');
        $this->createIndex('namecountry_name_id', '{{namecountry}}', 'namecountry_name_id');
    }

    public function down()
    {
        $this->dropTable('{{namecountry}}');
    }
}