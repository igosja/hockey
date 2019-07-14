<?php

use yii\db\Migration;

/**
 * Class m190714_075011_lineup
 */
class m190714_075011_lineup extends Migration
{
    const TABLE = '{{%lineup}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'lineup_assist_power', $this->integer(2)->defaultValue(0)->after('lineup_assist'));
        $this->addColumn(self::TABLE, 'lineup_assist_short', $this->integer(2)->defaultValue(0)->after('lineup_assist_power'));
        $this->addColumn(self::TABLE, 'lineup_face_off', $this->integer(2)->defaultValue(0)->after('lineup_captain'));
        $this->addColumn(self::TABLE, 'lineup_face_off_win', $this->integer(2)->defaultValue(0)->after('lineup_face_off'));
        $this->addColumn(self::TABLE, 'lineup_game_with_shootout', $this->integer(1)->defaultValue(0)->after('lineup_game_id'));
        $this->addColumn(self::TABLE, 'lineup_loose', $this->integer(1)->defaultValue(0)->after('lineup_line_id'));
        $this->addColumn(self::TABLE, 'lineup_point', $this->integer(2)->defaultValue(0)->after('lineup_plus_minus'));
        $this->addColumn(self::TABLE, 'lineup_save', $this->integer(2)->defaultValue(0)->after('lineup_power_real'));
        $this->addColumn(self::TABLE, 'lineup_score_draw', $this->integer(2)->defaultValue(0)->after('lineup_score'));
        $this->addColumn(self::TABLE, 'lineup_score_power', $this->integer(2)->defaultValue(0)->after('lineup_score_draw'));
        $this->addColumn(self::TABLE, 'lineup_score_short', $this->integer(2)->defaultValue(0)->after('lineup_score_power'));
        $this->addColumn(self::TABLE, 'lineup_score_win', $this->integer(1)->defaultValue(0)->after('lineup_score_short'));
        $this->addColumn(self::TABLE, 'lineup_shootout_win', $this->integer(1)->defaultValue(0)->after('lineup_shot'));
        $this->addColumn(self::TABLE, 'lineup_shutout', $this->integer(1)->defaultValue(0)->after('lineup_shootout_win'));
        $this->addColumn(self::TABLE, 'lineup_win', $this->integer(1)->defaultValue(0)->after('lineup_team_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'lineup_assist_power');
        $this->dropColumn(self::TABLE, 'lineup_assist_short');
        $this->dropColumn(self::TABLE, 'lineup_face_off');
        $this->dropColumn(self::TABLE, 'lineup_face_off_win');
        $this->dropColumn(self::TABLE, 'lineup_game_with_shootout');
        $this->dropColumn(self::TABLE, 'lineup_loose');
        $this->dropColumn(self::TABLE, 'lineup_point');
        $this->dropColumn(self::TABLE, 'lineup_save');
        $this->dropColumn(self::TABLE, 'lineup_score_draw');
        $this->dropColumn(self::TABLE, 'lineup_score_power');
        $this->dropColumn(self::TABLE, 'lineup_score_short');
        $this->dropColumn(self::TABLE, 'lineup_score_win');
        $this->dropColumn(self::TABLE, 'lineup_shootout_win');
        $this->dropColumn(self::TABLE, 'lineup_shutout');
        $this->dropColumn(self::TABLE, 'lineup_win');
    }
}
