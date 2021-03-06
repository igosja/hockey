<?php

use yii\db\Migration;

/**
 * Class m180619_144300_election_national_vote
 */
class m180619_144300_election_national_vote extends Migration
{
    const TABLE = '{{%election_national_vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_national_vote_id' => $this->primaryKey(11),
            'election_national_vote_application_id' => $this->integer(11)->defaultValue(0),
            'election_national_vote_date' => $this->integer(11)->defaultValue(0),
            'election_national_vote_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('election_national_vote_application_id', self::TABLE, 'election_national_vote_application_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
