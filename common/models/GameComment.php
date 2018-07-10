<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class GameComment
 * @package common\models
 *
 * @property integer $game_comment_id
 * @property integer $game_comment_check
 * @property integer $game_comment_date
 * @property integer $game_comment_game_id
 * @property string $game_comment_text
 * @property integer $game_comment_user_id
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
            [['game_comment_game_id'], 'in', 'range' => Game::find()->select(['game_id'])->column()],
            [['game_comment_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['game_comment_id', '$game_comment_check', 'game_comment_date'], 'integer'],
            [['game_comment_game_id', 'game_comment_text'], 'required'],
            [['game_comment_text'], 'safe'],
            [['game_comment_text'], 'trim'],
        ];
    }
}
