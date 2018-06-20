<?php

use yii\db\Migration;

/**
 * Class m180620_134301_squad
 */
class m180620_134301_squad extends Migration
{
    const TABLE = '{{%squad}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'squad_id' => $this->primaryKey(1),
            'squad_color' => $this->char(6),
            'squad_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['squad_color', 'squad_name'], [
            ['', '------'],
            ['DFF2BF', '1 squad'],
            ['C9FFCC', '2 squad'],
            ['FEEFB3', '3 squad'],
            ['FFBABA', '4 squad'],
            ['E0E0E0', '5 squad'],
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
