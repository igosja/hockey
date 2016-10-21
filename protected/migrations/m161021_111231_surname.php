<?php

class m161021_111231_surname extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{surname}}', array(
            'surname_id' => 'pk',
            'surname_name' => 'VARCHAR(255) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('{{surname}}');
    }
}