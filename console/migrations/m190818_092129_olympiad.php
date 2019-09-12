<?php

use yii\db\Migration;

/**
 * Class m190818_092129_olympiad
 */
class m190818_092129_olympiad extends Migration
{
    const TABLE = '{{%olympiad}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'olympiad_id' => $this->primaryKey(11),
            'olympiad_difference' => $this->integer(2)->defaultValue(0),
            'olympiad_game' => $this->integer(1)->defaultValue(0),
            'olympiad_group' => $this->integer(1)->defaultValue(0),
            'olympiad_loose' => $this->integer(1)->defaultValue(0),
            'olympiad_loose_overtime' => $this->integer(1)->defaultValue(0),
            'olympiad_loose_shootout' => $this->integer(1)->defaultValue(0),
            'olympiad_national_id' => $this->integer(3)->defaultValue(0),
            'olympiad_national_type_id' => $this->integer(1)->defaultValue(0),
            'olympiad_pass' => $this->integer(2)->defaultValue(0),
            'olympiad_place' => $this->integer(1)->defaultValue(0),
            'olympiad_point' => $this->integer(2)->defaultValue(0),
            'olympiad_score' => $this->integer(2)->defaultValue(0),
            'olympiad_season_id' => $this->integer(3)->defaultValue(0),
            'olympiad_win' => $this->integer(1)->defaultValue(0),
            'olympiad_win_overtime' => $this->integer(1)->defaultValue(0),
            'olympiad_win_shootout' => $this->integer(1)->defaultValue(0),
        ]);

        $this->createIndex('olympiad_national_id', self::TABLE, 'olympiad_national_id');
        $this->createIndex('olympiad_season_id', self::TABLE, 'olympiad_season_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
