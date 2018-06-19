<?php

use yii\db\Migration;

/**
 * Class m180619_143407_election_national_vice_application
 */
class m180619_143407_election_national_vice_application extends Migration
{
    const TABLE = '{{%election_national_vice_application}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'election_national_vice_application_id' => $this->primaryKey(11),
            'election_national_vice_application_date' => $this->integer(11)->defaultValue(0),
            'election_national_vice_application_election_national_vice_id' => $this->integer(11)->defaultValue(0),
            'election_national_vice_application_text' => $this->text(),
            'election_national_vice_application_user_id' => $this->integer(11)->defaultValue(0),
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
