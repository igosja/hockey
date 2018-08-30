<?php

use yii\db\Migration;

/**
 * Class m180619_171915_event_type
 */
class m180619_171915_event_type extends Migration
{
    const TABLE = '{{%event_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'event_type_id' => $this->primaryKey(1),
            'event_type_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['event_type_text'], [
            ['Goal'],
            ['Minor penalty'],
            ['Shootout'],
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
