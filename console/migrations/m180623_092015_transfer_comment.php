<?php

use yii\db\Migration;

/**
 * Class m180623_092015_transfer_comment
 */
class m180623_092015_transfer_comment extends Migration
{
    const TABLE = '{{%transfer_comment}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'transfer_comment_id' => $this->primaryKey(11),
            'transfer_comment_check' => $this->integer(11)->defaultValue(0),
            'transfer_comment_date' => $this->integer(11)->defaultValue(0),
            'transfer_comment_transfer_id' => $this->integer(11)->defaultValue(0),
            'transfer_comment_text' => $this->text(),
            'transfer_comment_user_id' => $this->integer(11)->defaultValue(0),
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
