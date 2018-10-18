<?php

use yii\db\Migration;

/**
 * Class m180621_152239_physical
 */
class m180621_152239_physical extends Migration
{
    const TABLE = '{{%physical}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'physical_id' => $this->primaryKey(2),
            'physical_opposite' => $this->integer(2)->defaultValue(0),
            'physical_value' => $this->integer(3)->defaultValue(0),
        ]);

        $this->batchInsert(self::TABLE, ['physical_opposite', 'physical_value'], [
            [1, 125],
            [20, 120],
            [19, 115],
            [18, 110],
            [17, 105],
            [16, 100],
            [15, 95],
            [14, 90],
            [13, 85],
            [12, 80],
            [11, 75],
            [10, 80],
            [9, 85],
            [8, 90],
            [7, 95],
            [6, 100],
            [5, 105],
            [4, 110],
            [3, 115],
            [2, 120],
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
