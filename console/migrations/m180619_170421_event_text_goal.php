<?php

use yii\db\Migration;

/**
 * Class m180619_170421_event_text_goal
 */
class m180619_170421_event_text_goal extends Migration
{
    const TABLE = '{{%event_text_goal}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'event_text_goal_id' => $this->primaryKey(1),
            'event_text_goal_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['event_text_goal_text'], [
            ['Shovel shot'],
            ['Wrist shot'],
            ['Snap shot'],
            ['Slap shot'],
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
