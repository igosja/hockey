<?php

use yii\db\Migration;

/**
 * Class m190525_063455_review_vote
 */
class m190525_063455_review_vote extends Migration
{
    const TABLE = '{{%review_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'review_vote_id' => $this->primaryKey(11),
            'review_vote_rating' => $this->integer(2)->defaultValue(0),
            'review_vote_review_id' => $this->integer(11)->defaultValue(0),
            'review_vote_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('review_vote_review_id', self::TABLE, 'review_vote_review_id');
        $this->createIndex('review_vote_user_id', self::TABLE, 'review_vote_user_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
