<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ForumChapter
 * @package common\models
 *
 * @property integer $forum_chapter_id
 * @property string $forum_chapter_name
 * @property integer $forum_chapter_order
 */
class ForumChapter extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forum_chapter}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['forum_chapter_id', 'forum_chapter_order'], 'integer'],
            [['forum_chapter_name'], 'required'],
            [['forum_chapter_name'], 'string', 'max' => 255],
            [['forum_chapter_name'], 'trim'],
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
                $order = self::find()->max('forum_chapter_order');
                if (!$order) {
                    $order = 0;
                }
                $order++;
                $this->forum_chapter_order = $order;
            }
            return true;
        }
        return false;
    }
}
