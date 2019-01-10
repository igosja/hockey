<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class ForumTheme
 * @package common\models
 *
 * @property int $forum_theme_id
 * @property int $forum_theme_count_view
 * @property int $forum_theme_date
 * @property int $forum_theme_date_update
 * @property int $forum_theme_forum_group_id
 * @property string $forum_theme_name
 * @property int $forum_theme_user_id
 *
 * @property ForumGroup $forumGroup
 * @property ForumMessage[] $forumMessage
 * @property User $user
 */
class ForumTheme extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forum_theme}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'forum_theme_id',
                    'forum_theme_count_view',
                    'forum_theme_date',
                    'forum_theme_forum_group_id',
                    'forum_theme_date_update',
                    'forum_theme_user_id',
                ],
                'integer'
            ],
            [['forum_theme_name'], 'required'],
            [['forum_theme_name'], 'string', 'max' => 255],
            [['forum_theme_name'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->forum_theme_date = time();
                $this->forum_theme_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getForumGroup()
    {
        return $this->hasOne(ForumGroup::class, ['forum_group_id' => 'forum_theme_forum_group_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getForumMessage()
    {
        return $this
            ->hasMany(ForumMessage::class, ['forum_message_forum_theme_id' => 'forum_theme_id'])
            ->orderBy(['forum_message_date' => SORT_DESC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'forum_theme_user_id']);
    }
}
