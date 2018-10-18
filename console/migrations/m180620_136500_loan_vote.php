<?php

use yii\db\Migration;

/**
 * Class m180620_136500_loan_vote
 */
class m180620_136500_loan_vote extends Migration
{
    const TABLE = '{{%loan_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'loan_vote_id' => $this->primaryKey(11),
            'loan_vote_loan_id' => $this->integer(11)->defaultValue(0),
            'loan_vote_rating' => $this->integer(2)->defaultValue(0),
            'loan_vote_user_id' => $this->integer(11)->defaultValue(0),
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
