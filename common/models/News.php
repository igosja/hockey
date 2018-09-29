<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class News extends ActiveRecord
{
    const PAGE_LIMIT = 10;

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
            'news_id' => 'ID',
            'news_date' => 'Date',
            'news_title' => 'Title',
            'news_text' => 'Text',
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
                $this->news_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'news_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsComment(): ActiveQuery
    {
        return $this->hasMany(NewsComment::class, ['news_comment_news_id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'news_user_id']);
    }
}
