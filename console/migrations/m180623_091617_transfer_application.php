<?php

use yii\db\Migration;

/**
 * Class m180623_091617_transfer_application
 */
class m180623_091617_transfer_application extends Migration
{
    const TABLE = '{{%transfer_application}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'transfer_application_id' => $this->primaryKey(11),
            'transfer_application_date' => $this->integer(11)->defaultValue(0),
            'transfer_application_only_one' => $this->integer(1)->defaultValue(0),
            'transfer_application_price' => $this->integer(11)->defaultValue(0),
            'transfer_application_team_id' => $this->integer(11)->defaultValue(0),
            'transfer_application_transfer_id' => $this->integer(11)->defaultValue(0),
            'transfer_application_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('transfer_application_transfer_id', self::TABLE, 'transfer_application_transfer_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
