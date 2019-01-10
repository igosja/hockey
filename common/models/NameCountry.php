<?php

namespace common\models;

/**
 * Class NameCountry
 * @package common\models
 *
 * @property int $name_country_country_id
 * @property int $name_country_name_id
 */
class NameCountry extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%name_country}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name_country_country_id', 'name_country_name_id'], 'integer'],
            [['name_country_country_id', 'name_country_name_id'], 'required'],
        ];
    }

    /**
     * @param integer $countryId
     * @return false|null|string
     */
    public static function getRandNameId($countryId)
    {
        return self::find()
            ->select(['name_country_name_id'])
            ->where(['name_country_country_id' => $countryId])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
