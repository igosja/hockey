<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * Class Sex
 * @package common\models
 *
 * @property int $sex_id
 * @property string $sex_name
 */
class Sex extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['sex_id'], 'integer'],
            [['sex_name'], 'required'],
            [['sex_name'], 'string', 'max' => 10],
            [['sex_name'], 'trim'],
        ];
    }

    /**
     * @return array
     */
    public static function selectOptions(): array
    {
        return ArrayHelper::map(self::find()->all(), 'sex_id', 'sex_name');
    }
}
