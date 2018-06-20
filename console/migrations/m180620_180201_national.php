<?php

use yii\db\Migration;

/**
 * Class m180620_180201_national
 */
class m180620_180201_national extends Migration
{
    const TABLE = '{{%name_country}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'national_id' => $this->primaryKey(3),
            'national_country_id' => $this->integer(3)->defaultValue(0),
            'national_finance' => $this->integer(11)->defaultValue(0),
            'national_mood_rest' => $this->integer(1)->defaultValue(0),
            'national_mood_super' => $this->integer(1)->defaultValue(0),
            'national_national_type_id' => $this->integer(1)->defaultValue(0),
            'national_power_c_16' => $this->integer(5)->defaultValue(0),
            'national_power_c_21' => $this->integer(5)->defaultValue(0),
            'national_power_c_27' => $this->integer(5)->defaultValue(0),
            'national_power_s_16' => $this->integer(5)->defaultValue(0),
            'national_power_s_21' => $this->integer(5)->defaultValue(0),
            'national_power_s_27' => $this->integer(5)->defaultValue(0),
            'national_power_v' => $this->integer(5)->defaultValue(0),
            'national_power_vs' => $this->integer(5)->defaultValue(0),
            'national_stadium_id' => $this->integer(11)->defaultValue(0),
            'national_user_id' => $this->integer(11)->defaultValue(0),
            'national_vice_id' => $this->integer(11)->defaultValue(0),
            'national_visitor' => $this->integer(3)->defaultValue(0),
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
