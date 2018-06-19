<?php

use yii\db\Migration;

/**
 * Class m180619_145934_election_president_vote
 */
class m180619_145934_election_president_vote extends Migration
{
    const TABLE = '{{%election_president_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_president_vote_id' => $this->primaryKey(11),
            'election_president_vote_application_id' => $this->integer(11)->defaultValue(0),
            'election_president_vote_date' => $this->integer(11)->defaultValue(0),
            'election_president_vote_election_id' => $this->integer(11)->defaultValue(0),
            'election_president_vote_user_id' => $this->integer(11)->defaultValue(0),
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
