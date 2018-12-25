<?php

use yii\db\Migration;

/**
 * Class m180619_172257_finance
 */
class m180619_172257_finance extends Migration
{
    const TABLE = '{{%finance}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'finance_id' => $this->primaryKey(11),
            'finance_building_id' => $this->integer(1)->defaultValue(0),
            'finance_capacity' => $this->integer(5)->defaultValue(0),
            'finance_comment' => $this->text(),
            'finance_country_id' => $this->integer(3)->defaultValue(0),
            'finance_date' => $this->integer(11)->defaultValue(0),
            'finance_finance_text_id' => $this->integer(2)->defaultValue(0),
            'finance_level' => $this->integer(1)->defaultValue(0),
            'finance_national_id' => $this->integer(3)->defaultValue(0),
            'finance_player_id' => $this->integer(11)->defaultValue(0),
            'finance_season_id' => $this->integer(3)->defaultValue(0),
            'finance_team_id' => $this->integer(5)->defaultValue(0),
            'finance_user_id' => $this->integer(11)->defaultValue(0),
            'finance_value' => $this->integer(11)->defaultValue(0),
            'finance_value_after' => $this->integer(11)->defaultValue(0),
            'finance_value_before' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('finance_country_id', self::TABLE, 'finance_country_id');
        $this->createIndex('finance_national_id', self::TABLE, 'finance_national_id');
        $this->createIndex('finance_team_id', self::TABLE, 'finance_team_id');
        $this->createIndex('finance_user_id', self::TABLE, 'finance_user_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
