<?php

use yii\db\Migration;

/**
 * Class m180623_094306_vote_answer
 */
class m180623_094306_vote_answer extends Migration
{
    const TABLE = '{{%vote_answer}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'vote_answer_id' => $this->primaryKey(11),
            'vote_answer_text' => $this->text(),
            'vote_answer_vote_id' => $this->integer(11)->defaultValue(0),
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
