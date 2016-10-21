<?php

class m161021_111335_position extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{position}}', array(
            'position_id' => 'pk',
            'position_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->insertMultiple('{{position}}', array(
            array('position_name' => 'GK'),
            array('position_name' => 'LD'),
            array('position_name' => 'RD'),
            array('position_name' => 'LW'),
            array('position_name' => 'C'),
            array('position_name' => 'RW'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{position}}');
    }
}