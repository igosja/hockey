<?php

use yii\db\Migration;

/**
 * Class m180623_094455_vote_status
 */
class m180623_094455_vote_status extends Migration
{
    const TABLE = '{{%vote_status}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'vote_status_id' => $this->primaryKey(1),
            'vote_status_name' => $this->string(25),
        ]);

        $this->batchInsert(self::TABLE, ['vote_status_name'], [
            ['Pending verification'],
            ['Open'],
            ['Closed'],
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
