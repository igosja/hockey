<?php

use yii\db\Migration;

/**
 * Class m190909_181357_history_text_fire_reason
 */
class m190909_181357_history_text_fire_reason extends Migration
{
    const TABLE = '{{%history}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'history_fire_reason', $this->integer(1)->defaultValue(0)->after('history_date'));
        $this->update(self::TABLE, ['history_fire_reason' => 1], ['history_history_text_id' => [4, 8, 12]]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'history_fire_reason');
    }
}
