<?php

use yii\db\Migration;

/**
 * Class m180619_164525_event_text_shootout
 */
class m180619_164525_event_text_shootout extends Migration
{
    const TABLE = '{{%event_text_shootout}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'event_text_shootout_id' => $this->primaryKey(1),
            'event_text_shootout_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['event_text_shootout_text'], [
            ['Shootout (goal)'],
            ['Shootout (no goal)'],
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
