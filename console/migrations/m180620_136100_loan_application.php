<?php

use yii\db\Migration;

/**
 * Class m180620_136100_loan_application
 */
class m180620_136100_loan_application extends Migration
{
    const TABLE = '{{%loan_application}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'loan_application_id' => $this->primaryKey(11),
            'loan_application_date' => $this->integer(11)->defaultValue(0),
            'loan_application_day' => $this->integer(1)->defaultValue(0),
            'loan_application_loan_id' => $this->integer(11)->defaultValue(0),
            'loan_application_only_one' => $this->integer(1)->defaultValue(0),
            'loan_application_price' => $this->integer(11)->defaultValue(0),
            'loan_application_team_id' => $this->integer(11)->defaultValue(0),
            'loan_application_user_id' => $this->integer(11)->defaultValue(0),
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
