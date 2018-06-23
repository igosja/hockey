<?php

use yii\db\Migration;

/**
 * Class m180623_093830_vote
 */
class m180623_093830_vote extends Migration
{
    const TABLE = '{{%vote}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'vote_id' => $this->primaryKey(1),
            'vote_country_id' => $this->integer(3)->defaultValue(0),
            'vote_date' => $this->integer(11)->defaultValue(0),
            'vote_text' => $this->text(),
            'vote_user_id' => $this->integer(11)->defaultValue(0),
            'vote_vote_status_id' => $this->integer(1)->defaultValue(0),
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
