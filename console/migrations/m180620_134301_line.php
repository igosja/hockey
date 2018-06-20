<?php

use yii\db\Migration;

/**
 * Class m180620_134301_line
 */
class m180620_134301_line extends Migration
{
    const TABLE = '{{%league_distribution}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'line_id' => $this->primaryKey(1),
            'line_color' => $this->char(6),
            'line_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['line_color', 'line_name'], [
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
