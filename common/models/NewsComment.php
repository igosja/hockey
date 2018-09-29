<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class NewsComment
 * @package common\models
 *
 * @property int $news_comment_id
 * @property int $news_comment_check
 * @property int $news_comment_date
 * @property int $news_comment_news_id
 * @property string $news_comment_text
 * @property int $news_comment_user_id
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
            [
                [
                    'news_comment_id',
                    '$news_comment_check',
                    'news_comment_date',
                    'news_comment_news_id',
                    'news_comment_user_id',
                ],
                'integer'
            ],
            [['news_comment_news_id', 'news_comment_text'], 'required'],
            [['news_comment_text'], 'safe'],
            [['news_comment_text'], 'trim'],
        ];
    }
}
