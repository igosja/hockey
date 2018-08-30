<?php

use yii\db\Migration;

/**
 * Class m180622_150330_statistic_chapter
 */
class m180622_150330_statistic_chapter extends Migration
{
    const TABLE = '{{%statistic_chapter}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'statistic_chapter_id' => $this->primaryKey(1),
            'statistic_chapter_name' => $this->string(10),
            'statistic_chapter_order' => $this->integer(1),
        ]);

        $this->batchInsert(self::TABLE, ['statistic_chapter_name', 'statistic_chapter_order'], [
            ['Teams', 1],
            ['Players', 2],
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
