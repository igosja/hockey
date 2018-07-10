<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class NewsComment
 * @package common\models
 *
 * @property integer $news_comment_id
 * @property integer $news_comment_check
 * @property integer $news_comment_date
 * @property integer $news_comment_news_id
 * @property string $news_comment_text
 * @property integer $news_comment_user_id
 */
class NewsComment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['news_comment_news_id'], 'in', 'range' => News::find()->select(['news_id'])->column()],
            [['news_comment_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['news_comment_id', '$news_comment_check', 'news_comment_date'], 'integer'],
            [['news_comment_news_id', 'news_comment_text'], 'required'],
            [['news_comment_text'], 'safe'],
            [['news_comment_text'], 'trim'],
        ];
    }
}
