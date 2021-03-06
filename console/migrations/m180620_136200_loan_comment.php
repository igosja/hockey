<?php

use yii\db\Migration;

/**
 * Class m180620_136200_loan_comment
 */
class m180620_136200_loan_comment extends Migration
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

        $this->createIndex('loan_comment_check', self::TABLE, 'loan_comment_check');
        $this->createIndex('loan_comment_loan_id', self::TABLE, 'loan_comment_loan_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
