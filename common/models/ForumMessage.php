<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class ForumTheme
 * @package common\models
 *
 * @property int $forum_message_id
 * @property int $forum_message_blocked
 * @property int $forum_message_check
 * @property int $forum_message_date
 * @property int $forum_message_date_update
 * @property int $forum_message_forum_theme_id
 * @property string $forum_message_text
 * @property int $forum_message_user_id
 *
 * @property ForumTheme $forumTheme
 * @property User $user
 */
class ForumMessage extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%forum_message}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'forum_message_id',
                    'forum_message_blocked',
                    'forum_message_check',
                    'forum_message_date',
                    'forum_message_date_update',
                    'forum_message_forum_theme_id',
                    'forum_message_user_id',
                ],
                'integer'
            ],
            [['forum_message_text'], 'required'],
            [['forum_message_text'], 'safe'],
            [['forum_message_text'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->forum_message_date = HockeyHelper::unixTimeStamp();
                $this->forum_message_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumTheme(): ActiveQuery
    {
        return $this->hasOne(ForumTheme::class, ['forum_theme_id' => 'forum_message_forum_theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'forum_theme_user_id']);
    }
}
