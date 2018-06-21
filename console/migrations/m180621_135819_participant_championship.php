<?php

use yii\db\Migration;

/**
 * Class m180621_135819_participant_championship
 */
class m180621_135819_participant_championship extends Migration
{
    const TABLE = '{{%participant_championship}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [

            'participant_championship_id' => $this->primaryKey(11),
            'participant_championship_country_id' => $this->integer(3)->defaultValue(0),
            'participant_championship_division_id' => $this->integer(1)->defaultValue(0),
            'participant_championship_season_id' => $this->integer(3)->defaultValue(0),
            'participant_championship_stage_id' => $this->integer(2)->defaultValue(0),
            'participant_championship_stage_1' => $this->integer(1)->defaultValue(0),
            'participant_championship_stage_2' => $this->integer(1)->defaultValue(0),
            'participant_championship_stage_4' => $this->integer(1)->defaultValue(0),
            'participant_championship_team_id' => $this->integer(11)->defaultValue(0),
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
