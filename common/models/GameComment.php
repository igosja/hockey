<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class GameComment
 * @package common\models
 *
 * @property int $game_comment_id
 * @property int $game_comment_check
 * @property int $game_comment_date
 * @property int $game_comment_game_id
 * @property string $game_comment_text
 * @property int $game_comment_user_id
 */
class GameComment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%game_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'game_comment_id',
                    '$game_comment_check',
                    'game_comment_date',
                    'game_comment_game_id',
                    'game_comment_user_id',
                ],
                'integer'
            ],
            [['game_comment_game_id', 'game_comment_text'], 'required'],
            [['game_comment_text'], 'safe'],
            [['game_comment_text'], 'trim'],
        ];
    }
}
