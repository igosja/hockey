<?php

use yii\db\Migration;

/**
 * Class m180623_092400_transfer_special
 */
class m180623_092400_transfer_special extends Migration
{
    const TABLE = '{{%transfer_special}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'transfer_special_id' => $this->primaryKey(11),
            'transfer_special_level' => $this->integer(1)->defaultValue(0),
            'transfer_special_transfer_id' => $this->integer(11)->defaultValue(0),
            'transfer_special_special_id' => $this->integer(2)->defaultValue(0),
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
