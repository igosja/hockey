<?php

use yii\db\Migration;

/**
 * Class m190126_143506_user_ip
 */
class m190126_143506_user_ip extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_ip', $this->string(255)->after('user_holiday_day'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_ip');
    }
}
