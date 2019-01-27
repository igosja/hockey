<?php

namespace common\models;

use common\components\FormatHelper;
use DateInterval;
use DateTime;
use yii\db\ActiveQuery;

/**
 * Class BuildingStadium
 * @package common\models
 *
 * @property int $building_stadium_id
 * @property int $building_stadium_capacity
 * @property int $building_stadium_construction_type_id
 * @property int $building_stadium_date
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
    public static function tableName()
    {
        return '{{%building_stadium}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'building_stadium_id',
                    'building_stadium_capacity',
                    'building_stadium_construction_type_id',
                    'building_stadium_date',
                    'building_stadium_day',
                    'building_stadium_ready',
                    'building_stadium_team_id',
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
                $this->building_stadium_date = time();
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
        $day = $this->building_stadium_day;

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
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'building_stadium_team_id']);
    }
}
