<?php

class m161021_111242_surnamecountry extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{surnamecountry}}', array(
            'surnamecountry_id' => 'pk',
            'surnamecountry_country_id' => 'INT(11) DEFAULT 0',
            'surnamecountry_surname_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('surnamecountry_country_id', '{{surnamecountry}}', 'surnamecountry_country_id');
        $this->createIndex('surnamecountry_surname_id', '{{surnamecountry}}', 'surnamecountry_surname_id');
    }

    public function down()
    {
        $this->dropTable('{{surnamecountry}}');
    }
}