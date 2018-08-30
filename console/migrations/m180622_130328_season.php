<?php

use yii\db\Migration;

/**
 * Class m180622_130328_season
 */
class m180622_130328_season extends Migration
{
    const TABLE = '{{%season}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'season_id' => $this->primaryKey(3),
        ]);

        $this->insert(self::TABLE, [
            'season_id' => null,
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
