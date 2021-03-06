<?php

namespace common\models;

use yii\helpers\Html;

/**
 * Class Physical
 * @package common\models
 *
 * @property int $physical_id
 * @property string $physical_name
 * @property int $physical_opposite
 * @property int $physical_value
 */
class Physical extends AbstractActiveRecord
{
    const DEFAULT_ID = 16;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['physical_opposite'], 'in', self::find()->select(['physical_id'])->column()],
            [['physical_id', 'physical_value'], 'integer'],
            [['physical_name', 'physical_value'], 'required'],
            [['physical_name'], 'string', 'max' => 20],
            [['physical_name'], 'trim'],
        ];
    }

    /**
     * @return Physical
     */
    public static function getRandPhysical(): Physical
    {
        $physicalArray = self::find()
            ->select(['physical_id', 'physical_value'])
            ->all();
        return $physicalArray[array_rand($physicalArray)];
    }

    /**
     * @return string
     */
    public function image(): string
    {
        return Html::img(
            '/img/physical/' . $this->physical_id . '.png',
            [
                'alt' => $this->physical_name,
                'title' => $this->physical_name,
            ]
        );
    }
}
