<?php

namespace common\models;

/**
 * Class LineupTemplate
 * @package common\models
 *
 * @property int $lineup_template_id
 * @property string $lineup_template_captain
 * @property string $lineup_template_name
 * @property int $lineup_template_national_id
 * @property int $lineup_template_player_cf_1
 * @property int $lineup_template_player_cf_2
 * @property int $lineup_template_player_cf_3
 * @property int $lineup_template_player_cf_4
 * @property int $lineup_template_player_gk_1
 * @property int $lineup_template_player_gk_2
 * @property int $lineup_template_player_ld_1
 * @property int $lineup_template_player_ld_2
 * @property int $lineup_template_player_ld_3
 * @property int $lineup_template_player_ld_4
 * @property int $lineup_template_player_lw_1
 * @property int $lineup_template_player_lw_2
 * @property int $lineup_template_player_lw_3
 * @property int $lineup_template_player_lw_4
 * @property int $lineup_template_player_rd_1
 * @property int $lineup_template_player_rd_2
 * @property int $lineup_template_player_rd_3
 * @property int $lineup_template_player_rd_4
 * @property int $lineup_template_player_rw_1
 * @property int $lineup_template_player_rw_2
 * @property int $lineup_template_player_rw_3
 * @property int $lineup_template_player_rw_4
 * @property int $lineup_template_rudeness_id_1
 * @property int $lineup_template_rudeness_id_2
 * @property int $lineup_template_rudeness_id_3
 * @property int $lineup_template_rudeness_id_4
 * @property int $lineup_template_style_id_1
 * @property int $lineup_template_style_id_2
 * @property int $lineup_template_style_id_3
 * @property int $lineup_template_style_id_4
 * @property int $lineup_template_tactic_id_1
 * @property int $lineup_template_tactic_id_2
 * @property int $lineup_template_tactic_id_3
 * @property int $lineup_template_tactic_id_4
 * @property int $lineup_template_team_id
 */
class LineupTemplate extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%lineup_template}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'lineup_template_id',
                    'lineup_template_captain',
                    'lineup_template_national_id',
                    'lineup_template_player_cf_1',
                    'lineup_template_player_cf_2',
                    'lineup_template_player_cf_3',
                    'lineup_template_player_cf_4',
                    'lineup_template_player_gk_1',
                    'lineup_template_player_gk_2',
                    'lineup_template_player_ld_1',
                    'lineup_template_player_ld_2',
                    'lineup_template_player_ld_3',
                    'lineup_template_player_ld_4',
                    'lineup_template_player_lw_1',
                    'lineup_template_player_lw_2',
                    'lineup_template_player_lw_3',
                    'lineup_template_player_lw_4',
                    'lineup_template_player_rd_1',
                    'lineup_template_player_rd_2',
                    'lineup_template_player_rd_3',
                    'lineup_template_player_rd_4',
                    'lineup_template_player_rw_1',
                    'lineup_template_player_rw_2',
                    'lineup_template_player_rw_3',
                    'lineup_template_player_rw_4',
                    'lineup_template_rudeness_id_1',
                    'lineup_template_rudeness_id_2',
                    'lineup_template_rudeness_id_3',
                    'lineup_template_rudeness_id_4',
                    'lineup_template_style_id_1',
                    'lineup_template_style_id_2',
                    'lineup_template_style_id_3',
                    'lineup_template_style_id_4',
                    'lineup_template_tactic_id_1',
                    'lineup_template_tactic_id_2',
                    'lineup_template_tactic_id_3',
                    'lineup_template_tactic_id_4',
                    'lineup_template_team_id',
                ],
                'integer'
            ],
            [['lineup_template_name'], 'string', 'max' => 255],
        ];
    }
}
