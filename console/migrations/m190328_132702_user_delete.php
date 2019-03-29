<?php

use yii\db\Migration;

/**
 * Class m190328_132702_user_delete
 */
class m190328_132702_user_delete extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_date_delete', $this->integer()->defaultValue(0)->after('user_date_confirm'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_date_delete');
    }
}
