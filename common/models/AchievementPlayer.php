<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class AchievementPlayer
 * @package common\models
 *
 * @property integer $achievement_player_id
 * @property integer $achievement_player_country_id
 * @property integer $achievement_player_division_id
 * @property integer $achievement_player_is_playoff
 * @property integer $achievement_player_national_id
 * @property integer $achievement_player_place
 * @property integer $achievement_player_player_id
 * @property integer $achievement_player_season_id
 * @property integer $achievement_player_stage_id
 * @property integer $achievement_player_team_id
 * @property integer $achievement_player_tournament_type_id
 */
class AchievementPlayer extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%achievement_player}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'achievement_player_id',
                    'achievement_player_country_id',
                    'achievement_player_division_id',
                    'achievement_player_is_playoff',
                    'achievement_player_national_id',
                    'achievement_player_place',
                    'achievement_player_player_id',
                    'achievement_player_season_id',
                    'achievement_player_stage_id',
                    'achievement_player_team_id',
                    'achievement_player_tournament_type_id',
                ],
                'integer'
            ],
        ];
    }
}
