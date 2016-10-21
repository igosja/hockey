<?php

class m161021_111258_player extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{player}}', array(
            'player_id' => 'pk',
            'player_age' => 'INT(11) DEFAULT 0',
            'player_country_id' => 'INT(11) DEFAULT 0',
            'player_game_row' => 'INT(11) DEFAULT -1',
            'player_name_id' => 'INT(11) DEFAULT 0',
            'player_power_real' => 'SMALLINT(3) DEFAULT 0',
            'player_power_nominal' => 'SMALLINT(3) DEFAULT 0',
            'player_power_old' => 'SMALLINT(3) DEFAULT 0',
            'player_price' => 'INT(11) DEFAULT 0',
            'player_rent_day' => 'TINYINT(2) DEFAULT 0',
            'player_rent_on' => 'TINYINT(1) DEFAULT 0',
            'player_rent_price' => 'INT(11) DEFAULT 0',
            'player_rent_team_id' => 'INT(11) DEFAULT 0',
            'player_salary' => 'INT(11) DEFAULT 0',
            'player_school_id' => 'INT(11) DEFAULT 0',
            'player_shape' => 'TINYINT(2) DEFAULT 0',
            'player_style_id' => 'TINYINT(1) DEFAULT 0',
            'player_surname_id' => 'INT(11) DEFAULT 0',
            'player_team_id' => 'INT(11) DEFAULT 0',
            'player_tire' => 'TINYINT(3) DEFAULT 0',
            'player_training_ability' => 'TINYINT(2) DEFAULT 0',
            'player_transfer_on' => 'TINYINT(1) DEFAULT 0',
            'player_transfer_price' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('player_country_id', '{{player}}', 'player_country_id');
        $this->createIndex('player_name_id', '{{player}}', 'player_name_id');
        $this->createIndex('player_rent_on', '{{player}}', 'player_rent_on');
        $this->createIndex('player_rent_team_id', '{{player}}', 'player_rent_team_id');
        $this->createIndex('player_school_id', '{{player}}', 'player_school_id');
        $this->createIndex('player_style_id', '{{player}}', 'player_style_id');
        $this->createIndex('player_surname_id', '{{player}}', 'player_surname_id');
        $this->createIndex('player_team_id', '{{player}}', 'player_team_id');
        $this->createIndex('player_transfer_on', '{{player}}', 'player_transfer_on');
    }

    public function down()
    {
        $this->dropTable('{{player}}');
    }
}