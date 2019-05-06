<?php

use yii\db\Migration;

/**
 * Class m190506_141802_snapshot_bot
 */
class m190506_141802_snapshot_bot extends Migration
{
    const TABLE = '{{%snapshot}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'snapshot_bot', $this->integer(3)->defaultValue(0)->after('snapshot_base_training'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'snapshot_bot');
    }
}
