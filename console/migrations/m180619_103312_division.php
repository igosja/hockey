<?php

use yii\db\Migration;

/**
 * Class m180619_103312_division
 */
class m180619_103312_division extends Migration
{
    const TABLE = '{{%division}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'division_id' => $this->primaryKey(1),
            'division_name' => $this->string(2),
        ]);

        $this->batchInsert(self::TABLE, ['division_name'], [
            ['D1'],
            ['D2'],
            ['D3'],
            ['D4'],
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
