<?php

use yii\db\Migration;

/**
 * Class m180621_180434_rating_team
 */
class m180621_180434_rating_team extends Migration
{
    const TABLE = '{{%rating_team}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'rating_team_id' => $this->primaryKey(11),
            'rating_team_age_place' => $this->integer(11)->defaultValue(0),
            'rating_team_age_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_base_place' => $this->integer(11)->defaultValue(0),
            'rating_team_base_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_player_place' => $this->integer(11)->defaultValue(0),
            'rating_team_player_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_power_vs_place' => $this->integer(11)->defaultValue(0),
            'rating_team_power_vs_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_price_base_place' => $this->integer(11)->defaultValue(0),
            'rating_team_price_base_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_price_stadium_place' => $this->integer(11)->defaultValue(0),
            'rating_team_price_stadium_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_price_total_place' => $this->integer(11)->defaultValue(0),
            'rating_team_price_total_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_stadium_place' => $this->integer(11)->defaultValue(0),
            'rating_team_stadium_place_country' => $this->integer(11)->defaultValue(0),
            'rating_team_team_id' => $this->integer(11)->defaultValue(0),
            'rating_team_visitor_place' => $this->integer(11)->defaultValue(0),
            'rating_team_visitor_place_country' => $this->integer(11)->defaultValue(0),
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
