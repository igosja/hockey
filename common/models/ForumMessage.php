<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 */
class ForumMessage extends ActiveRecord
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
                ['forum_message_forum_theme_id'],
                'in',
                'range' => ForumTheme::find()->select(['forum_theme_id'])->column()
            ],
            [['forum_message_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [
                [
                    'forum_message_id',
                    'forum_message_blocked',
                    'forum_message_check',
                    'forum_message_date',
                    'forum_message_date_update'
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
                $this->forum_message_date = time();
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
