<?php

use yii\db\Migration;

/**
 * Class m180620_122319_history
 */
class m180620_122319_history extends Migration
{
    const TABLE = '{{%history}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'history_id' => $this->primaryKey(11),
            'history_building_id' => $this->integer(1)->defaultValue(0),
            'history_country_id' => $this->integer(3)->defaultValue(0),
            'history_date' => $this->integer(11)->defaultValue(0),
            'history_game_id' => $this->integer(11)->defaultValue(0),
            'history_history_text_id' => $this->integer(2)->defaultValue(0),
            'history_national_id' => $this->integer(3)->defaultValue(0),
            'history_player_id' => $this->integer(11)->defaultValue(0),
            'history_position_id' => $this->integer(1)->defaultValue(0),
            'history_season_id' => $this->integer(5)->defaultValue(0),
            'history_special_id' => $this->integer(2)->defaultValue(0),
            'history_team_id' => $this->integer(11)->defaultValue(0),
            'history_team_2_id' => $this->integer(11)->defaultValue(0),
            'history_user_id' => $this->integer(11)->defaultValue(0),
            'history_user_2_id' => $this->integer(11)->defaultValue(0),
            'history_value' => $this->integer(11)->defaultValue(0),
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
