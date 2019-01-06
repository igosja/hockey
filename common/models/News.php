<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class News
 * @package common\models
 *
 * @property int $news_id
 * @property int $news_check
 * @property int $news_country_id
 * @property int $news_date
 * @property string $news_text
 * @property string $news_title
 * @property int $news_user_id
 *
 * @property Country $country
 * @property NewsComment $newsComment
 * @property User $user
 */
class News extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['news_id', 'news_check', 'news_country_id', 'news_date', 'news_user_id'], 'integer'],
            [['news_text', 'news_title'], 'required'],
            [['news_title'], 'string', 'max' => 255],
            [['news_text', 'news_title'], 'trim'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'news_id' => 'Id',
            'news_date' => 'Дата',
            'news_title' => 'Заголовок',
            'news_text' => 'Текст',
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
                $this->news_date = time();
                if (!$this->news_user_id) {
                    $this->news_user_id = Yii::$app->user->id;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return nl2br($this->news_text);
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'news_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNewsComment(): ActiveQuery
    {
        return $this->hasMany(NewsComment::class, ['news_comment_news_id' => 'news_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'news_user_id'])->cache();
    }
}
