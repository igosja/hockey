<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ForumTheme
 * @package common\models
 *
 * @property integer $forum_theme_id
 * @property integer $forum_theme_count_view
 * @property integer $forum_theme_date
 * @property integer $forum_theme_date_update
 * @property integer $forum_theme_forum_group_id
 * @property string $forum_theme_name
 * @property integer $forum_theme_user_id
 *
 * @property ForumGroup $forumGroup
 */
class ForumTheme extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%forum_theme}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['forum_theme_forum_group_id'], 'in', 'range' => ForumGroup::find()->select(['forum_group_id'])->column()],
            [['forum_theme_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['forum_theme_id', 'forum_theme_count_view', 'forum_theme_date', 'forum_theme_date_update'], 'integer'],
            [['forum_theme_name'], 'required'],
            [['forum_theme_name'], 'string', 'max' => 255],
            [['forum_theme_name'], 'trim'],
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
                $this->forum_theme_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumGroup(): ActiveQuery
    {
        return $this->hasOne(ForumGroup::class, ['forum_group_id' => 'forum_theme_forum_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'forum_theme_user_id']);
    }
}
