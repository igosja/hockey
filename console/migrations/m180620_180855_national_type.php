<?php

use yii\db\Migration;

/**
 * Class m180620_180855_national_type
 */
class m180620_180855_national_type extends Migration
{
    const TABLE = '{{%national_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'national_type_id' => $this->primaryKey(1),
            'national_type_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['national_type_name'], [
            ['Национальная'],
            ['U-21'],
            ['U-19'],
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
