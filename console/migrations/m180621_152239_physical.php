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
            'physical_name' => $this->string(20),
            'physical_opposite' => $this->integer(2)->defaultValue(0),
            'physical_value' => $this->integer(3)->defaultValue(0),
        ]);

        $this->batchInsert(self::TABLE, ['physical_name', 'physical_opposite', 'physical_value'], [
            ['125%, decreases', 1, 125],
            ['120%, decreases', 20, 120],
            ['115%, decreases', 19, 115],
            ['110%, decreases', 18, 110],
            ['105%, decreases', 17, 105],
            ['100%, decreases', 16, 100],
            ['95%, decreases', 15, 95],
            ['90%, decreases', 14, 90],
            ['85%, decreases', 13, 85],
            ['80%, decreases', 12, 80],
            ['75%, increases', 11, 75],
            ['80%, increases', 10, 80],
            ['85%, increases', 9, 85],
            ['90%, increases', 8, 90],
            ['95%, increases', 7, 95],
            ['100%, increases', 6, 100],
            ['105%, increases', 5, 105],
            ['110%, increases', 4, 110],
            ['115%, increases', 3, 115],
            ['120%, increases', 2, 120],
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
