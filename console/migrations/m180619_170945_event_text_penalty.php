<?php

use yii\db\Migration;

/**
 * Class m180619_170945_event_text_penalty
 */
class m180619_170945_event_text_penalty extends Migration
{
    const TABLE = '{{%event_text_penalty}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'event_text_penalty_id' => $this->primaryKey(1),
            'event_text_penalty_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['event_text_penalty_text'], [
            ['Charging'],
            ['Cross-checking'],
            ['Elbowing'],
            ['High-sticking'],
            ['Hooking'],
            ['Interference'],
            ['Kneeing'],
            ['Roughing'],
            ['Slashing'],
            ['Tripping'],
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
