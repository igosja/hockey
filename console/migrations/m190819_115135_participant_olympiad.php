<?php

use yii\db\Migration;

/**
 * Class m190819_115135_participant_olympiad
 */
class m190819_115135_participant_olympiad extends Migration
{
    const TABLE = '{{%participant_olympiad}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'participant_olympiad_id' => $this->primaryKey(11),
            'participant_olympiad_national_id' => $this->integer(3)->defaultValue(0),
            'participant_olympiad_season_id' => $this->integer(3)->defaultValue(0),
            'participant_olympiad_stage_1' => $this->integer(2)->defaultValue(0),
            'participant_olympiad_stage_2' => $this->integer(2)->defaultValue(0),
            'participant_olympiad_stage_4' => $this->integer(2)->defaultValue(0),
            'participant_olympiad_stage_8' => $this->integer(2)->defaultValue(0),
            'participant_olympiad_stage_id' => $this->integer(2)->defaultValue(0),
        ]);

        $this->createIndex('participant_olympiad_season_id', self::TABLE, 'participant_olympiad_season_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
