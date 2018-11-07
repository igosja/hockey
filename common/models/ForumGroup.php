<?php

namespace common\models;

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
}
