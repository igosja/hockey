<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

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
 *
 * @property User $user
 */
class NewsComment extends AbstractActiveRecord
{
    const PAGE_LIMIT = 20;

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
                    'news_comment_check',
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

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'news_comment_text' => 'Комментарий',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->news_comment_date = new Expression('UNIX_TIMESTAMP()');
            $this->news_comment_user_id = Yii::$app->user->id;
        }
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'news_comment_user_id']);
    }
}
