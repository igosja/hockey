<?php

use yii\db\Migration;

/**
 * Class m180620_131803_league
 */
class m180620_131803_league extends Migration
{
    const TABLE = '{{%league}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'league_id' => $this->primaryKey(11),
            'league_difference' => $this->integer(2)->defaultValue(0),
            'league_game' => $this->integer(1)->defaultValue(0),
            'league_group' => $this->integer(1)->defaultValue(0),
            'league_loose' => $this->integer(1)->defaultValue(0),
            'league_loose_overtime' => $this->integer(1)->defaultValue(0),
            'league_loose_shootout' => $this->integer(1)->defaultValue(0),
            'league_pass' => $this->integer(2)->defaultValue(0),
            'league_place' => $this->integer(1)->defaultValue(0),
            'league_point' => $this->integer(2)->defaultValue(0),
            'league_score' => $this->integer(2)->defaultValue(0),
            'league_season_id' => $this->integer(3)->defaultValue(0),
            'league_team_id' => $this->integer(11)->defaultValue(0),
            'league_win' => $this->integer(1)->defaultValue(0),
            'league_win_overtime' => $this->integer(1)->defaultValue(0),
            'league_win_shootout' => $this->integer(1)->defaultValue(0),
        ]);

        $this->createIndex('league_season_id', self::TABLE, 'league_season_id');
        $this->createIndex('league_team_id', self::TABLE, 'league_team_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
