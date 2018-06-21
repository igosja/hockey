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
            'position_name' => $this->integer(2),
            'position_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['position_name', 'position_text'], [
            ['GK', 'Goalkeeper'],
            ['LD', 'Left defender'],
            ['RD', 'Right defender'],
            ['LW', 'Left winger'],
            ['CF', 'Center forward'],
            ['RW', 'Right winger'],
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
