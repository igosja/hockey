<?php

use yii\db\Migration;

/**
 * Class m180619_134627_election_national__player
 */
class m180619_134627_election_national_player extends Migration
{
    const TABLE = '{{%election_national_player}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_national_player_id' => $this->primaryKey(11),
            'election_national_player_application_id' => $this->integer(11)->defaultValue(0),
            'election_national_player_player_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('election_national_player_application_id', self::TABLE, 'election_national_player_application_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
