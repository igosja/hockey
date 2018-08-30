<?php

use yii\db\Migration;

/**
 * Class m180619_093316_conference
 */
class m180619_093316_conference extends Migration
{
    const TABLE = '{{%conference}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'conference_id' => $this->primaryKey(11),
            'conference_difference' => $this->integer(3)->defaultValue(0),
            'conference_game' => $this->integer(2)->defaultValue(0),
            'conference_guest' => $this->integer(2)->defaultValue(0),
            'conference_home' => $this->integer(2)->defaultValue(0),
            'conference_loose' => $this->integer(2)->defaultValue(0),
            'conference_loose_overtime' => $this->integer(2)->defaultValue(0),
            'conference_loose_shootout' => $this->integer(2)->defaultValue(0),
            'conference_pass' => $this->integer(3)->defaultValue(0),
            'conference_place' => $this->integer(2)->defaultValue(0),
            'conference_point' => $this->integer(2)->defaultValue(0),
            'conference_score' => $this->integer(3)->defaultValue(0),
            'conference_season_id' => $this->integer(5)->defaultValue(0),
            'conference_team_id' => $this->integer(11)->defaultValue(0),
            'conference_win' => $this->integer(2)->defaultValue(0),
            'conference_win_overtime' => $this->integer(2)->defaultValue(0),
            'conference_win_shootout' => $this->integer(2)->defaultValue(0),
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
