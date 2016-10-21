<?php

class m161021_111522_season extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{season}}', array(
            'season_id' => 'pk',
        ));

        $this->insert('{{season}}', array('season_id' => null));
    }

    public function down()
    {
        $this->dropTable('{{season}}');
    }
}