<?php

use yii\db\Migration;

/**
 * Class m180622_123609_schedule
 */
class m180622_123609_schedule extends Migration
{
    const TABLE = '{{%schedule}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'schedule_id' => $this->primaryKey(11),
            'schedule_date' => $this->integer(11)->defaultValue(0),
            'schedule_season_id' => $this->integer(3)->defaultValue(0),
            'schedule_stage_id' => $this->integer(2)->defaultValue(0),
            'schedule_tournament_type_id' => $this->integer(1)->defaultValue(0),
        ]);

        $this->createIndex('schedule_season_id', self::TABLE, 'schedule_season_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
