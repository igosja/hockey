<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Stadium
 * @package common\models
 *
 * @property integer $stadium_id
 * @property integer $stadium_capacity
 * @property integer $stadium_city_id
 * @property integer $stadium_date
 * @property integer $stadium_maintenance
 * @property string $stadium_name
 *
 * @property City $city
 * @property Team[] $team
 */
class Stadium extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%stadium}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['stadium_city_id'], 'in', 'range' => City::find()->select(['city_id'])->column()],
            [['stadium_id', 'stadium_capacity', 'stadium_date', 'stadium_maintenance'], 'integer'],
            [['stadium_city_id', 'stadium_name'], 'required'],
            [['stadium_name'], 'string', 'max' => 255],
            [['stadium_name'], 'trim'],
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
                $this->stadium_capacity = 100;
                $this->stadium_date = time();
                $this->countMaintenance();
            }
            return true;
        }
        return false;
    }

    public function countMaintenance()
    {
        $this->stadium_maintenance = round(pow($this->stadium_capacity, 2) / 1000);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['city_id' => 'stadium_city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_stadium_id' => 'stadium_id']);
    }
}