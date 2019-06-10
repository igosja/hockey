<?php

namespace common\models;

/**
 * Class NationalType
 * @package common\models
 *
 * @property int $national_type_id
 * @property string $national_type_name
 */
class NationalType extends AbstractActiveRecord
{
    const U19 = 3;
    const U21 = 2;
    const MAIN = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%national_type}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['national_type_id'], 'integer'],
            [['national_type_name'], 'required'],
            [['national_type_name'], 'string', 'max' => 10],
            [['national_type_name'], 'trim'],
        ];
    }

    /**
     * @return int|null
     */
    public function getAgeLimit()
    {
        $result = null;

        if (self::U21 == $this->national_type_id) {
            $result = 21;
        } elseif (self::U19 == $this->national_type_id) {
            $result = 19;
        }

        return $result;
    }
}
