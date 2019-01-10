<?php

namespace common\models;

/**
 * Class LoanVote
 * @package common\models
 *
 * @property int $loan_vote_id
 * @property int $loan_vote_loan_id
 * @property int $loan_vote_rating
 * @property int $loan_vote_user_id
 */
class LoanVote extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%loan_vote}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'loan_vote_id',
                    'loan_vote_loan_id',
                    'loan_vote_rating',
                    'loan_vote_user_id',
                ],
                'integer'
            ]
        ];
    }
}
