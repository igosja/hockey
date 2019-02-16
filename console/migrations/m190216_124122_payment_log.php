<?php

use yii\db\Migration;

/**
 * Class m190216_124122_payment_log
 */
class m190216_124122_payment_log extends Migration
{
    const TABLE = '{{%payment}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'payment_log', $this->text()->after('payment_date'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'payment_log');
    }
}
