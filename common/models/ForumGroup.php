<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ForumGroup
 * @package common\models
 *
 * @property integer $forum_group_id
 * @property integer $forum_group_country_id
 * @property integer $forum_group_description
 * @property integer $forum_group_forum_chapter_id
 * @property integer $forum_group_name
 * @property integer $forum_group_order
 */
class ForumGroup extends ActiveRecord
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
            [['forum_group_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['forum_group_forum_chapter_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['forum_group_id', 'forum_group_order'], 'integer'],
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
