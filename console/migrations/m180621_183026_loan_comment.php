<?php

use yii\db\Migration;

/**
 * Class m180621_183026_loan_comment
 */
class m180621_183026_loan_comment extends Migration
{
    const TABLE = '{{%loan_comment}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'loan_comment_id' => $this->primaryKey(11),
            'loan_comment_check' => $this->integer(11)->defaultValue(0),
            'loan_comment_date' => $this->integer(11)->defaultValue(0),
            'loan_comment_loan_id' => $this->integer(11)->defaultValue(0),
            'loan_comment_text' => $this->text(),
            'loan_comment_user_id' => $this->integer(11)->defaultValue(0),
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
