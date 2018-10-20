<?php

use yii\db\Migration;

/**
 * Class m180622_184614_style
 */
class m180622_184614_style extends Migration
{
    const TABLE = '{{%style}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'style_id' => $this->primaryKey(1),
            'style_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['style_name'], [
            ['норма'],
            ['сила'],
            ['скорость'],
            ['техника'],
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
