<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Achievement
 * @package common\models
 *
 * @property int $achievement_id
 * @property int $achievement_country_id
 * @property int $achievement_division_id
 * @property int $achievement_is_playoff
 * @property int $achievement_national_id
 * @property int $achievement_place
 * @property int $achievement_season_id
 * @property int $achievement_stage_id
 * @property int $achievement_team_id
 * @property int $achievement_tournament_type_id
 * @property int $achievement_user_id
 */
class Achievement extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%achievement}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
