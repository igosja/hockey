<?php

class m161021_111508_log extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{log}}', array(
            'log_id' => 'pk',
            'log_building_id' => 'INT(11) DEFAULT 0',
            'log_country_id' => 'INT(11) DEFAULT 0',
            'log_date' => 'INT(11) DEFAULT 0',
            'log_game_id' => 'INT(11) DEFAULT 0',
            'log_logtext_id' => 'INT(11) DEFAULT 0',
            'log_national_id' => 'INT(11) DEFAULT 0',
            'log_player_id' => 'INT(11) DEFAULT 0',
            'log_position_id' => 'INT(11) DEFAULT 0',
            'log_season_id' => 'INT(11) DEFAULT 0',
            'log_special_id' => 'INT(11) DEFAULT 0',
            'log_team_id' => 'INT(11) DEFAULT 0',
            'log_team_2_id' => 'INT(11) DEFAULT 0',
            'log_user_id' => 'INT(11) DEFAULT 0',
            'log_value' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('log_player_id', '{{log}}', 'log_player_id');
        $this->createIndex('log_team_id', '{{log}}', 'log_team_id');
        $this->createIndex('log_user_id', '{{log}}', 'log_user_id');
    }

    public function down()
    {
        $this->dropTable('{{log}}');
    }
}