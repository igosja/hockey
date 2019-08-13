<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ReviewGame
 * @package common\models
 *
 * @property int $review_game_id
 * @property int $review_game_game_id
 * @property int $review_game_review_id
 * @property string $review_game_text
 *
 * @property Game $game
 */
class ReviewGame extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'review_game_id',
                    'review_game_game_id',
                    'review_game_review_id',
                ],
                'integer'
            ],
            [['review_game_text'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getGame(): ActiveQuery
    {
        return $this->hasOne(Game::class, ['game_id' => 'review_game_game_id'])->cache();
    }
}
