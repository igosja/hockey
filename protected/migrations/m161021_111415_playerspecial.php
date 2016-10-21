<?php

class m161021_111415_playerspecial extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{playerspecial}}', array(
            'playerspecial_id' => 'pk',
            'playerspecial_level' => 'TINYINT(1) DEFAULT 0',
            'playerspecial_player_id' => 'INT(11) DEFAULT 0',
            'playerspecial_special_id' => 'TINYINT(1) DEFAULT 0',
        ));

        $this->createIndex('playerspecial_player_id', '{{playerspecial}}', 'playerspecial_player_id');
        $this->createIndex('playerspecial_special_id', '{{playerspecial}}', 'playerspecial_special_id');
    }

    public function down()
    {
        $this->dropTable('{{playerspecial}}');
    }
}