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
     * @return array
     */
    public function rules(): array
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
    public static function getRandNameId(int $countryId): int
    {
        return self::find()
            ->select(['name_country_name_id'])
            ->where(['name_country_country_id' => $countryId])
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }
}
