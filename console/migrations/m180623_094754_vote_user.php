<?php

use yii\db\Migration;

/**
 * Class m180623_094754_vote_user
 */
class m180623_094754_vote_user extends Migration
{
    const TABLE = '{{%vote_user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'vote_user_id' => $this->primaryKey(1),
            'vote_user_answer_id' => $this->integer(11)->defaultValue(0),
            'vote_user_date' => $this->integer(11)->defaultValue(0),
            'vote_user_user_id' => $this->integer(11)->defaultValue(0),
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
