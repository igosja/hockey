<?php

use yii\db\Migration;

/**
 * Class m190310_153429_player_national_squad_id
 */
class m190310_153429_player_national_squad_id extends Migration
{
    const TABLE = '{{%player}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->renameColumn(self::TABLE, 'player_national_line_id', 'player_national_squad_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
