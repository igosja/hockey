<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class BuildingStadium
 * @package common\models
 *
 * @property int $building_stadium_id
 * @property int $building_stadium_capacity
 * @property int $building_stadium_construction_type_id
 * @property int $building_stadium_day
 * @property int $building_stadium_ready
 * @property int $building_stadium_team_id
 *
 * @property Team $team
 */
class BuildingStadium extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%building_stadium}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'building_stadium_id',
                    'building_stadium_capacity',
                    'building_stadium_construction_type_id',
                    'building_stadium_day',
                    'building_stadium_ready',
                    'building_stadium_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'building_stadium_team_id']);
    }
}
