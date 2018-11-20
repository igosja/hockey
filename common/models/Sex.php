<?php

namespace common\models;

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
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%sex}}';
    }

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
}
