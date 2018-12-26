<?php

namespace common\models;

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use Exception;
use Yii;
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
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->building_stadium_date = HockeyHelper::unixTimeStamp();
            }
            return true;
        }
        return false;
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
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'building_stadium_team_id']);
    }
}
