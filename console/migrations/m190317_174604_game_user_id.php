<?php

use yii\db\Migration;

/**
 * Class m190317_174604_game_user_id
 */
class m190317_174604_game_user_id extends Migration
{
    const TABLE = '{{%game}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'game_guest_user_id', $this->integer()->defaultValue(0)->after('game_guest_teamwork_4'));
        $this->addColumn(self::TABLE, 'game_home_user_id', $this->integer()->defaultValue(0)->after('game_home_teamwork_4'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'game_guest_user_id');
        $this->dropColumn(self::TABLE, 'game_home_user_id');
    }
}
