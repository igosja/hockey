<?php

namespace common\models;

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
 */
class Stadium extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%stadium}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['stadium_id', 'stadium_capacity', 'stadium_city_id', 'stadium_date', 'stadium_maintenance'], 'integer'],
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
}
