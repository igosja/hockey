<?php

use yii\db\Migration;

/**
 * Class m180621_151752_payment
 */
class m180621_151752_payment extends Migration
{
    const TABLE = '{{%payment}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'payment_id' => $this->primaryKey(11),
            'payment_date' => $this->integer(11)->defaultValue(0),
            'payment_status' => $this->integer(1)->defaultValue(0),
            'payment_sum' => $this->decimal(11, 2)->defaultValue(0),
            'payment_user_id' => $this->integer(11)->defaultValue(0),
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
