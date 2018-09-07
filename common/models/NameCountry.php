<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class NameCountry
 * @package common\models
 *
 * @property integer $name_country_id
 * @property integer $name_country_country_id
 * @property integer $name_country_name_id
 */
class NameCountry extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%name_country}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name_country_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['name_country_name_id'], 'in', 'range' => Name::find()->select(['name_id'])->column()],
            [['name_country_id'], 'integer'],
            [['name_country_country_id', 'name_country_name_id'], 'required'],
        ];
    }

    /**
     * @param integer $countryId
     * @return false|null|string
     */
    public static function getRandNameId(int $countryId)
    {
        return self::find()
            ->select(['name_country_name_id'])
            ->where(['name_country_country_id' => $countryId])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}