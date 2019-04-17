<?php

use yii\db\Migration;

/**
 * Class m190417_162940_support_country
 */
class m190417_162940_support_country extends Migration
{
    const TABLE = '{{%support}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'support_country_id', $this->integer(3)->defaultValue(0)->after('support_admin_id'));
        $this->addColumn(self::TABLE, 'support_president_id', $this->integer()->defaultValue(0)->after('support_date'));
        $this->addColumn(self::TABLE, 'support_inside', $this->integer(1)->defaultValue(0)->after('support_date'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'support_country_id');
        $this->dropColumn(self::TABLE, 'support_president_id');
        $this->dropColumn(self::TABLE, 'support_inside');
    }
}
