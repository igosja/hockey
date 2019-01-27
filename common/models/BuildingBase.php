<?php

namespace common\models;

use common\components\FormatHelper;
use DateInterval;
use DateTime;
use yii\db\ActiveQuery;

/**
 * Class BuildingBase
 * @package common\models
 *
 * @property int $building_base_id
 * @property int $building_base_building_id
 * @property int $building_base_construction_type_id
 * @property int $building_base_date
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
    public static function tableName()
    {
        return '{{%building_base}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'building_base_id',
                    'building_base_building_id',
                    'building_base_construction_type_id',
                    'building_base_date',
                    'building_base_day',
                    'building_base_ready',
                    'building_base_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->building_base_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function endDate()
    {
        $day = $this->building_base_day;

        $today = (new DateTime())->setTime(9, 0, 0)->getTimestamp();

        if ($today > time()) {
            $day--;
        }

        $interval = new DateInterval('P' . $day . 'D');
        $end = (new DateTime())->add($interval)->getTimestamp();

        return FormatHelper::asDate($end);
    }

    /**
     * @return ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::class, ['building_id' => 'building_base_building_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'building_base_team_id']);
    }
}
