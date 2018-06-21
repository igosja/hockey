<?php

use yii\db\Migration;

/**
 * Class m180621_184416_rudeness
 */
class m180621_184416_rudeness extends Migration
{
    const TABLE = '{{%rudeness}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'rudeness_id' => $this->primaryKey(1),
            'rudeness_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['rudeness_name'], [
            ['Normal'],
            ['Rough'],
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
