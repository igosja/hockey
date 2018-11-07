<?php

namespace common\models;

/**
 * Class RatingUser
 * @package common\models
 *
 * @property int $rating_user_id
 * @property int $rating_user_rating_place
 * @property int $rating_user_user_id
 */
class RatingUser extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rating_user}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
}
