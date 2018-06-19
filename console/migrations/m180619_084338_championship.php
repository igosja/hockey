<?php

use yii\db\Migration;

/**
 * Class m180619_084338_championship
 */
class m180619_084338_championship extends Migration
{
    const TABLE = '{{%championship}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'championship_id' => $this->primaryKey(11),
            'championship_country_id' => $this->integer(3)->defaultValue(0),
            'championship_difference' => $this->integer(3)->defaultValue(0),
            'championship_division_id' => $this->integer(1)->defaultValue(0),
            'championship_game' => $this->integer(2)->defaultValue(0),
            'championship_loose' => $this->integer(2)->defaultValue(0),
            'championship_loose_bullet' => $this->integer(2)->defaultValue(0),
            'championship_loose_over' => $this->integer(2)->defaultValue(0),
            'championship_pass' => $this->integer(3)->defaultValue(0),
            'championship_place' => $this->integer(2)->defaultValue(0),
            'championship_point' => $this->integer(2)->defaultValue(0),
            'championship_score' => $this->integer(3)->defaultValue(0),
            'championship_season_id' => $this->integer(5)->defaultValue(0),
            'championship_team_id' => $this->integer(5)->defaultValue(0),
            'championship_win' => $this->integer(2)->defaultValue(0),
            'championship_win_bullet' => $this->integer(2)->defaultValue(0),
            'championship_win_over' => $this->integer(2)->defaultValue(0),
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
