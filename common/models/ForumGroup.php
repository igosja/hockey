<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ForumGroup
 * @package common\models
 *
 * @property int $forum_group_id
 * @property int $forum_group_country_id
 * @property int $forum_group_description
 * @property int $forum_group_forum_chapter_id
 * @property int $forum_group_name
 * @property int $forum_group_order
 *
 * @property ForumChapter $forumChapter
 * @property ForumMessage $forumMessage
 * @property ForumTheme[] $forumTheme
 */
class ForumGroup extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%forum_group}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['forum_group_id', 'forum_group_country_id', 'forum_group_forum_chapter_id', 'forum_group_order'],
                'integer'
            ],
            [['forum_group_description', 'forum_group_name'], 'required'],
            [['forum_group_name'], 'string', 'max' => 255],
            [['forum_group_description', 'forum_group_name'], 'trim'],
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
                $order = self::find()
                    ->where(['forum_group_forum_chapter_id' => $this->forum_group_forum_chapter_id])
                    ->max('forum_group_order');
                if (!$order) {
                    $order = 0;
                }
                $order++;
                $this->forum_group_order = $order;
            }
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function countMessage(): int
    {
        $result = 0;
        foreach ($this->forumTheme as $forumTheme) {
            $result = $result + count($forumTheme->forumMessage);
        }
        return $result;
    }

    /**
     * @return int
     */
    public function countTheme(): int
    {
        return count($this->forumTheme);
    }

    /**
     * @return ActiveQuery
     */
    public function getForumChapter(): ActiveQuery
    {
        return $this->hasOne(ForumChapter::class, ['forum_chapter_id' => 'forum_group_forum_chapter_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getForumMessage(): ActiveQuery
    {
        return $this
            ->hasOne(ForumMessage::class, ['forum_message_forum_theme_id' => 'forum_group_id'])
            ->via('forumTheme')
            ->orderBy(['forum_message_date' => SORT_ASC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getForumTheme(): ActiveQuery
    {
        return $this->hasMany(ForumTheme::class, ['forum_theme_forum_group_id' => 'forum_group_id']);
    }
}
