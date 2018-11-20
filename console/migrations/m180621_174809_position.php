<?php

use yii\db\Migration;

/**
 * Class m180621_174809_position
 */
class m180621_174809_position extends Migration
{
    const TABLE = '{{%position}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'position_id' => $this->primaryKey(1),
            'position_name' => $this->string(2),
            'position_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['position_name', 'position_text'], [
            ['GK', 'Вратарь'],
            ['LD', 'Левый защитник'],
            ['RD', 'Правый защитник'],
            ['LW', 'Левый нападающий'],
            ['CF', 'Центральный нападающий'],
            ['RW', 'Правый нападающий'],
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
