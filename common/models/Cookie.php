<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Cookie
 * @package common\models
 *
 * @property int $cookie_id
 * @property int $cookie_count
 * @property int $cookie_date
 * @property int $cookie_user_1_id
 * @property int $cookie_user_2_id
 *
 * @property User $userOne
 * @property User $userTwo
 */
class Cookie extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%cookie}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'cookie_id',
                    'cookie_count',
                    'cookie_date',
                    'cookie_user_1_id',
                    'cookie_user_2_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserOne()
    {
        return $this->hasOne(User::class, ['user_id' => 'cookie_user_1_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserTwo()
    {
        return $this->hasOne(User::class, ['user_id' => 'cookie_user_2_id']);
    }
}
