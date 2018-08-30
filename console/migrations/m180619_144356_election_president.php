<?php

use yii\db\Migration;

/**
 * Class m180619_144356_election_president
 */
class m180619_144356_election_president extends Migration
{
    const TABLE = '{{%election_president}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_president_id' => $this->primaryKey(11),
            'election_president_country_id' => $this->integer(3)->defaultValue(0),
            'election_president_date' => $this->integer(11)->defaultValue(0),
            'election_president_election_status_id' => $this->integer(1)->defaultValue(0),
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
