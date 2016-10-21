<?php

class m161021_111317_team extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{team}}', array(
            'team_id' => 'pk',
            'team_base_id' => 'TINYINT(2) DEFAULT 1',
            'team_basemedical_id' => 'TINYINT(2) DEFAULT 1',
            'team_basephisical_id' => 'TINYINT(2) DEFAULT 1',
            'team_baseschool_id' => 'TINYINT(2) DEFAULT 1',
            'team_basescout_id' => 'TINYINT(2) DEFAULT 1',
            'team_basetraining_id' => 'TINYINT(2) DEFAULT 1',
            'team_finance' => 'INT(11) DEFAULT 1000000',
            'team_name' => 'VARCHAR(255) NOT NULL',
            'team_shop_position' => 'INT(11) DEFAULT 0',
            'team_shop_special' => 'INT(11) DEFAULT 0',
            'team_shop_training' => 'INT(11) DEFAULT 0',
            'team_stadium_id' => 'INT(11) DEFAULT 0',
            'team_user_id' => 'INT(11) DEFAULT 0',
            'team_vice_id' => 'INT(11) DEFAULT 0',
            'team_vote_junior' => 'TINYINT(1) DEFAULT 2',
            'team_vote_national' => 'TINYINT(1) DEFAULT 2',
            'team_vote_president' => 'TINYINT(1) DEFAULT 2',
            'team_vote_youth' => 'TINYINT(1) DEFAULT 2',
        ));

        $this->createIndex('team_base_id', '{{team}}', 'team_base_id');
        $this->createIndex('team_basemedical_id', '{{team}}', 'team_basemedical_id');
        $this->createIndex('team_basephisical_id', '{{team}}', 'team_basephisical_id');
        $this->createIndex('team_baseschool_id', '{{team}}', 'team_baseschool_id');
        $this->createIndex('team_basescout_id', '{{team}}', 'team_basescout_id');
        $this->createIndex('team_basetraining_id', '{{team}}', 'team_basetraining_id');
        $this->createIndex('team_stadium_id', '{{team}}', 'team_stadium_id');
        $this->createIndex('team_user_id', '{{team}}', 'team_user_id');
        $this->createIndex('team_vice_id', '{{team}}', 'team_vice_id');
    }

    public function down()
    {
        $this->dropTable('{{team}}');
    }
}