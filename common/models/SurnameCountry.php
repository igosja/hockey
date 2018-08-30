<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class SurnameCountry
 * @package common\models
 *
 * @property integer $surname_country_id
 * @property integer $surname_country_country_id
 * @property integer $surname_country_surname_id
 */
class SurnameCountry extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%surname_country}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['surname_country_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['surname_country_surname_id'], 'in', 'range' => Surname::find()->select(['surname_id'])->column()],
            [['surname_country_id'], 'integer'],
            [['surname_country_country_id', 'surname_country_surname_id'], 'required'],
        ];
    }

    /**
     * @param integer $countryId
     * @return false|null|string
     */
    public static function getRandSurnameId(int $countryId)
    {
        return self::find()
            ->select(['surname_country_surname_id'])
            ->where(['surname_country_country_id' => $countryId])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
