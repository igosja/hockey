<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class RatingUser
 * @package common\models
 *
 * @property int $rating_user_id
 * @property int $rating_user_rating_place
 * @property int $rating_user_user_id
 *
 * @property User $user
 */
class RatingUser extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%rating_user}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'rating_user_id',
                    'rating_user_rating_place',
                    'rating_user_user_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'rating_user_user_id'])->cache();
    }
}
