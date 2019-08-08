<?php

namespace common\models;

/**
 * Class ReviewVote
 * @package common\models
 *
 * @property int $review_vote_id
 * @property int $review_vote_rating
 * @property int $review_vote_review_id
 * @property int $review_vote_user_id
 */
class ReviewVote extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%review_vote}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'review_vote_id',
                    'review_vote_rating',
                    'review_vote_review_id',
                    'review_vote_user_id',
                ],
                'integer'
            ]
        ];
    }
}
