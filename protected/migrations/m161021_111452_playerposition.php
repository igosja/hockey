<?php

class m161021_111452_playerposition extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{playerposition}}', array(
            'playerposition_id' => 'pk',
            'playerposition_player_id' => 'INT(11) DEFAULT 0',
            'playerposition_position_id' => 'TINYINT(1) DEFAULT 0',
        ));

        $this->createIndex('playerposition_player_id', '{{playerposition}}', 'playerposition_player_id');
        $this->createIndex('playerposition_position_id', '{{playerposition}}', 'playerposition_position_id');
    }

    public function down()
    {
        $this->dropTable('{{playerposition}}');
    }
}