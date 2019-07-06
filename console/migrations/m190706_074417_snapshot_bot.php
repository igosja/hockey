<?php

use yii\db\Migration;

/**
 * Class m190706_074417_snapshot_bot
 */
class m190706_074417_snapshot_bot extends Migration
{
    const TABLE = '{{%snapshot}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->dropColumn(self::TABLE, 'snapshot_bot');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->addColumn(self::TABLE, 'snapshot_bot', $this->integer(3)->defaultValue(0)->after('snapshot_base_training'));
    }
}
