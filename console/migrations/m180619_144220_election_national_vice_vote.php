<?php

use yii\db\Migration;

/**
 * Class m180619_144220_election_national_vice_vote
 */
class m180619_144220_election_national_vice_vote extends Migration
{
    const TABLE = '{{%election_national_vice_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_national_vice_vote_id' => $this->primaryKey(11),
            'election_national_vice_vote_application_id' => $this->integer(11)->defaultValue(0),
            'election_national_vice_vote_date' => $this->integer(11)->defaultValue(0),
            'election_national_vice_vote_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('election_national_vice_vote_application_id', self::TABLE, 'election_national_vice_vote_application_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
