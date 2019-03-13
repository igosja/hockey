<?php

namespace common\models;

/**
 * Class GameVote
 * @package common\models
 *
 * @property int $game_vote_id
 * @property int $game_vote_game_id
 * @property int $game_vote_rating
 * @property int $game_vote_user_id
 */
class GameVote extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%game_vote}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'game_vote_id',
                    'game_vote_game_id',
                    'game_vote_rating',
                    'game_vote_user_id',
                ],
                'integer'
            ]
        ];
    }
}
