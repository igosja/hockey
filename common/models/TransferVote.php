<?php

namespace common\models;

/**
 * Class TransferVote
 * @package common\models
 *
 * @property int $transfer_vote_id
 * @property int $transfer_vote_transfer_id
 * @property int $transfer_vote_rating
 * @property int $transfer_vote_user_id
 */
class TransferVote extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%transfer_vote}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'transfer_vote_id',
                    'transfer_vote_transfer_id',
                    'transfer_vote_rating',
                    'transfer_vote_user_id',
                ],
                'integer'
            ]
        ];
    }
}
