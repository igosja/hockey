<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

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
 *
 * @property User $user
 */
class GameComment extends AbstractActiveRecord
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
                    'game_comment_check',
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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->game_comment_date = HockeyHelper::unixTimeStamp();
            $this->game_comment_user_id = Yii::$app->user->id;
        }
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'game_comment_user_id']);
    }
}
