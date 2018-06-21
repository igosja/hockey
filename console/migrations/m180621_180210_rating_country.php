<?php

use yii\db\Migration;

/**
 * Class m180621_180210_rating_country
 */
class m180621_180210_rating_country extends Migration
{
    const TABLE = '{{%rating_country}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'rating_country_id' => $this->primaryKey(11),
            'rating_country_auto_place' => $this->integer(3)->defaultValue(0),
            'rating_country_country_id' => $this->integer(3)->defaultValue(0),
            'rating_country_league_place' => $this->integer(3)->defaultValue(0),
            'rating_country_stadium_place' => $this->integer(3)->defaultValue(0),
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
