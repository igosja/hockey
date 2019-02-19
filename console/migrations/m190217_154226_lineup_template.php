<?php

use yii\db\Migration;

/**
 * Class m190217_154226_lineup_template
 */
class m190217_154226_lineup_template extends Migration
{
    const TABLE = '{{%lineup_template}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'lineup_template_id' => $this->primaryKey(),
            'lineup_template_captain' => $this->integer()->defaultValue(0),
            'lineup_template_name' => $this->string(),
            'lineup_template_national_id' => $this->integer()->defaultValue(0),
            'lineup_template_player_cf_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_cf_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_cf_3' => $this->integer()->defaultValue(0),
            'lineup_template_player_cf_4' => $this->integer()->defaultValue(0),
            'lineup_template_player_gk_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_gk_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_ld_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_ld_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_ld_3' => $this->integer()->defaultValue(0),
            'lineup_template_player_ld_4' => $this->integer()->defaultValue(0),
            'lineup_template_player_lw_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_lw_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_lw_3' => $this->integer()->defaultValue(0),
            'lineup_template_player_lw_4' => $this->integer()->defaultValue(0),
            'lineup_template_player_rd_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_rd_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_rd_3' => $this->integer()->defaultValue(0),
            'lineup_template_player_rd_4' => $this->integer()->defaultValue(0),
            'lineup_template_player_rw_1' => $this->integer()->defaultValue(0),
            'lineup_template_player_rw_2' => $this->integer()->defaultValue(0),
            'lineup_template_player_rw_3' => $this->integer()->defaultValue(0),
            'lineup_template_player_rw_4' => $this->integer()->defaultValue(0),
            'lineup_template_rudeness_id_1' => $this->integer(1)->defaultValue(0),
            'lineup_template_rudeness_id_2' => $this->integer(1)->defaultValue(0),
            'lineup_template_rudeness_id_3' => $this->integer(1)->defaultValue(0),
            'lineup_template_rudeness_id_4' => $this->integer(1)->defaultValue(0),
            'lineup_template_style_id_1' => $this->integer(1)->defaultValue(0),
            'lineup_template_style_id_2' => $this->integer(1)->defaultValue(0),
            'lineup_template_style_id_3' => $this->integer(1)->defaultValue(0),
            'lineup_template_style_id_4' => $this->integer(1)->defaultValue(0),
            'lineup_template_tactic_id_1' => $this->integer(1)->defaultValue(0),
            'lineup_template_tactic_id_2' => $this->integer(1)->defaultValue(0),
            'lineup_template_tactic_id_3' => $this->integer(1)->defaultValue(0),
            'lineup_template_tactic_id_4' => $this->integer(1)->defaultValue(0),
            'lineup_template_team_id' => $this->integer(3)->defaultValue(0),
        ]);

        $this->createIndex('lineup_template_national_id', self::TABLE, 'lineup_template_national_id');
        $this->createIndex('lineup_template_team_id', self::TABLE, 'lineup_template_team_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
