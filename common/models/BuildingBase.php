<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class BuildingBase
 * @package common\models
 *
 * @property int $building_base_id
 * @property int $building_base_building_id
 * @property int $building_base_construction_type_id
 * @property int $building_base_day
 * @property int $building_base_ready
 * @property int $building_base_team_id
 *
 * @property Building $building
 * @property Team $team
 */
class BuildingBase extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%building_base}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'building_base_id',
                    'building_base_building_id',
                    'building_base_construction_type_id',
                    'building_base_day',
                    'building_base_ready',
                    'building_base_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return string
     */
    public function endDate(): string
    {
        $day = $this->building_base_day;

        if (strtotime(date('Y-m-d 12:00:00')) > time()) {
            $day--;
        }

        try {
            $result = Yii::$app->formatter->asDate(strtotime('+' . $day . 'days'), 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $result = '';
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getBuilding(): ActiveQuery
    {
        return $this->hasOne(Building::class, ['building_id' => 'building_base_building_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'building_base_team_id']);
    }
}
