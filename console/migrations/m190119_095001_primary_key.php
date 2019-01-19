<?php

use yii\db\Migration;

/**
 * Class m190119_095001_primary_key
 */
class m190119_095001_primary_key extends Migration
{
    const TABLE = '{{%player_special}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'player_special_id', $this->primaryKey());
        $this->alterColumn(self::TABLE, 'player_special_level', $this->integer()->after('player_special_id'));
        $this->alterColumn(self::TABLE, 'player_special_player_id', $this->integer()->after('player_special_level'));
        $this->alterColumn(self::TABLE, 'player_special_special_id', $this->integer(2)->after('player_special_player_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'player_special_id');
    }
}
