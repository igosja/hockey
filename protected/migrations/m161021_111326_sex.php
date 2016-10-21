<?php

class m161021_111326_sex extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{sex}}', array(
            'sex_id' => 'pk',
            'sex_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->insertMultiple('{{sex}}', array(
            array('sex_name' => 'мужской'),
            array('sex_name' => 'женский'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{sex}}');
    }
}