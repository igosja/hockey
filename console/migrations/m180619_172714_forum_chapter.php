<?php

use yii\db\Migration;

/**
 * Class m180619_172714_forum_chapter
 */
class m180619_172714_forum_chapter extends Migration
{
    const TABLE = '{{%forum_chapter}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'forum_chapter_id' => $this->primaryKey(11),
            'forum_chapter_name' => $this->string(255),
            'forum_chapter_order' => $this->integer(1)->defaultValue(0),
        ]);

        $this->batchInsert(self::TABLE, ['forum_chapter_name', 'forum_chapter_order'], [
            ['General', 1],
            ['Deals and contracts', 2],
            ['Outside the League', 3],
            ['National forums', 4],
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
