<?php

use yii\db\Migration;

/**
 * Class m180620_183907_off_season
 */
class m180620_183907_off_season extends Migration
{
    const TABLE = '{{%off_season}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'off_season_id' => $this->primaryKey(11),
            'off_season_difference' => $this->integer(3)->defaultValue(0),
            'off_season_game' => $this->integer(2)->defaultValue(0),
            'off_season_guest' => $this->integer(2)->defaultValue(0),
            'off_season_home' => $this->integer(2)->defaultValue(0),
            'off_season_loose' => $this->integer(2)->defaultValue(0),
            'off_season_loose_overtime' => $this->integer(2)->defaultValue(0),
            'off_season_loose_shootout' => $this->integer(2)->defaultValue(0),
            'off_season_pass' => $this->integer(3)->defaultValue(0),
            'off_season_place' => $this->integer(11)->defaultValue(0),
            'off_season_point' => $this->integer(2)->defaultValue(0),
            'off_season_score' => $this->integer(3)->defaultValue(0),
            'off_season_season_id' => $this->integer(5)->defaultValue(0),
            'off_season_team_id' => $this->integer(11)->defaultValue(0),
            'off_season_win' => $this->integer(2)->defaultValue(0),
            'off_season_win_overtime' => $this->integer(2)->defaultValue(0),
            'off_season_win_shootout' => $this->integer(2)->defaultValue(0),
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
