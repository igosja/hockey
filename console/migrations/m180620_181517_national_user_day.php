<?php

use yii\db\Migration;

/**
 * Class m180620_181517_national_user_day
 */
class m180620_181517_national_user_day extends Migration
{
    const TABLE = '{{%national_user_day}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'national_user_day_id' => $this->primaryKey(11),
            'national_user_day_day' => $this->integer(3)->defaultValue(0),
            'national_user_day_national_id' => $this->integer(3)->defaultValue(0),
            'national_user_day_user_id' => $this->integer(11)->defaultValue(0),
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
