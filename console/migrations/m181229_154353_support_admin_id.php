<?php

use yii\db\Migration;

/**
 * Class m181229_154353_support_admin_id
 */
class m181229_154353_support_admin_id extends Migration
{
    const TABLE = '{{%support}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->dropIndex('support_user_id_from', self::TABLE);
        $this->dropIndex('support_user_id_to', self::TABLE);
        $this->addColumn(self::TABLE, 'support_question', $this->integer(1)->defaultValue(1)->after('support_date'));
        $this->renameColumn(self::TABLE, 'support_user_id_from', 'support_user_id');
        $this->renameColumn(self::TABLE, 'support_user_id_to', 'support_admin_id');
        $this->alterColumn(self::TABLE, 'support_admin_id', $this->integer()->defaultValue(0)->after('support_id'));
        $this->createIndex('support_user_id', self::TABLE, 'support_user_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('support_user_id', self::TABLE);
        $this->dropColumn(self::TABLE, 'support_question');
        $this->renameColumn(self::TABLE, 'support_user_id', 'support_user_id_from');
        $this->renameColumn(self::TABLE, 'support_admin_id', 'support_user_id_to');
        $this->createIndex('support_user_id_from', self::TABLE, 'support_user_id_from');
        $this->createIndex('support_user_id_to', self::TABLE, 'support_user_id_to');
    }
}
