<?php

use yii\db\Migration;

/**
 * Class m180620_136300_loan_position
 */
class m180620_136300_loan_position extends Migration
{
    const TABLE = '{{%loan_position}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'loan_position_id' => $this->primaryKey(11),
            'loan_position_loan_id' => $this->integer(11)->defaultValue(0),
            'loan_position_position_id' => $this->integer(1)->defaultValue(0),
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
