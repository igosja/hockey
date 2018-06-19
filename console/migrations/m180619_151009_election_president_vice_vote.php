<?php

use yii\db\Migration;

/**
 * Class m180619_151009_election_president_vice_vote
 */
class m180619_151009_election_president_vice_vote extends Migration
{
    const TABLE = '{{%election_president_vice_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_president_vice_vote_id' => $this->primaryKey(11),
            'election_president_vice_vote_application_id' => $this->integer(11)->defaultValue(0),
            'election_president_vice_vote_date' => $this->integer(11)->defaultValue(0),
            'election_president_vice_vote_election_id' => $this->integer(11)->defaultValue(0),
            'election_president_vice_vote_user_id' => $this->integer(11)->defaultValue(0),
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
