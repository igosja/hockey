<?php

use yii\db\Migration;

/**
 * Class m180623_092234_transfer_position
 */
class m180623_092234_transfer_position extends Migration
{
    const TABLE = '{{%transfer_position}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'transfer_position_id' => $this->primaryKey(11),
            'transfer_position_position_id' => $this->integer(1)->defaultValue(0),
            'transfer_position_transfer_id' => $this->integer(11)->defaultValue(0),
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
