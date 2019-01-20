<?php

namespace common\models;

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
     * @return string
     */
    public static function tableName()
    {
        return '{{%review_game}}';
    }

    /**
     * @return array
     */
    public function rules()
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
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::class, ['game_id' => 'review_game_game_id']);
    }
}
