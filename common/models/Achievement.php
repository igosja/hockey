<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Achievement
 * @package common\models
 *
 * @property integer $achievement_id
 * @property integer $achievement_country_id
 * @property integer $achievement_division_id
 * @property integer $achievement_is_playoff
 * @property integer $achievement_national_id
 * @property integer $achievement_place
 * @property integer $achievement_season_id
 * @property integer $achievement_stage_id
 * @property integer $achievement_team_id
 * @property integer $achievement_tournament_type_id
 * @property integer $achievement_user_id
 */
class Achievement extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%achievement}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'achievement_id',
                    'achievement_country_id',
                    'achievement_division_id',
                    'achievement_is_playoff',
                    'achievement_national_id',
                    'achievement_place',
                    'achievement_season_id',
                    'achievement_stage_id',
                    'achievement_team_id',
                    'achievement_tournament_type_id',
                    'achievement_user_id',
                ],
                'integer'
            ],
        ];
    }
}
