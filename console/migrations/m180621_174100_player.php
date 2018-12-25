<?php

use yii\db\Migration;

/**
 * Class m180621_174100_player
 */
class m180621_174100_player extends Migration
{
    const TABLE = '{{%player}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'player_id' => $this->primaryKey(11),
            'player_age' => $this->integer(2)->defaultValue(0),
            'player_country_id' => $this->integer(3)->defaultValue(0),
            'player_date_no_action' => $this->integer(11)->defaultValue(0),
            'player_date_rookie' => $this->integer(11)->defaultValue(0),
            'player_game_row' => $this->integer(2)->defaultValue(0),
            'player_game_row_old' => $this->integer(2)->defaultValue(0),
            'player_injury' => $this->integer(1)->defaultValue(0),
            'player_injury_day' => $this->integer(1)->defaultValue(0),
            'player_loan_day' => $this->integer(3)->defaultValue(0),
            'player_loan_team_id' => $this->integer(11)->defaultValue(0),
            'player_mood_id' => $this->integer(1)->defaultValue(0),
            'player_name_id' => $this->integer(11)->defaultValue(0),
            'player_national_id' => $this->integer(11)->defaultValue(0),
            'player_national_line_id' => $this->integer(1)->defaultValue(0),
            'player_no_deal' => $this->integer(1)->defaultValue(0),
            'player_order' => $this->integer(3)->defaultValue(0),
            'player_physical_id' => $this->integer(2)->defaultValue(0),
            'player_position_id' => $this->integer(1)->defaultValue(0),
            'player_power_nominal' => $this->integer(3)->defaultValue(0),
            'player_power_nominal_s' => $this->integer(3)->defaultValue(0),
            'player_power_old' => $this->integer(3)->defaultValue(0),
            'player_power_real' => $this->integer(3)->defaultValue(0),
            'player_price' => $this->integer(11)->defaultValue(0),
            'player_rookie' => $this->integer(1)->defaultValue(0),
            'player_salary' => $this->integer(11)->defaultValue(0),
            'player_school_id' => $this->integer(11)->defaultValue(0),
            'player_squad_id' => $this->integer(1)->defaultValue(0),
            'player_style_id' => $this->integer(1)->defaultValue(0),
            'player_surname_id' => $this->integer(11)->defaultValue(0),
            'player_team_id' => $this->integer(11)->defaultValue(0),
            'player_tire' => $this->integer(3)->defaultValue(0),
            'player_training_ability' => $this->integer(1)->defaultValue(0),
        ]);

        $this->createIndex('player_loan_team_id', self::TABLE, 'player_loan_team_id');
        $this->createIndex('player_national_id', self::TABLE, 'player_national_id');
        $this->createIndex('player_school_id', self::TABLE, 'player_school_id');
        $this->createIndex('player_team_id', self::TABLE, 'player_team_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
