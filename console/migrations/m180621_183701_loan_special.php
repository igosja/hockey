<?php

use yii\db\Migration;

/**
 * Class m180621_183701_loan_special
 */
class m180621_183701_loan_special extends Migration
{
    const TABLE = '{{%loan_special}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'loan_special_id' => $this->primaryKey(11),
            'loan_special_level' => $this->integer(1)->defaultValue(0),
            'loan_special_loan_id' => $this->integer(11)->defaultValue(0),
            'loan_special_special_id' => $this->integer(2)->defaultValue(0),
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
