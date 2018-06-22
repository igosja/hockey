<?php

use yii\db\Migration;

/**
 * Class m180622_150330_statistic_chapter
 */
class m180622_150330_statistic_chapter extends Migration
{
    const TABLE = '{{%statisticchapter}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'statisticchapter_id' => $this->primaryKey(1),
            'statisticchapter_name' => $this->string(10),
            'statisticchapter_order' => $this->integer(1),
        ]);

        $this->batchInsert(self::TABLE, ['statisticchapter', 'statisticchapter_order'], [
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
