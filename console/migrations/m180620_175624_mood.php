<?php

use yii\db\Migration;

/**
 * Class m180620_175624_mood
 */
class m180620_175624_mood extends Migration
{
    const TABLE = '{{%mood}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'mood_id' => $this->primaryKey(11),
            'mood_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['mood_name'], [
            ['super'],
            ['normal'],
            ['rest'],
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
