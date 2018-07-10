<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class News
 * @package common\models
 *
 * @property integer $news_id
 * @property integer $news_check
 * @property integer $news_country_id
 * @property integer $news_date
 * @property string $news_text
 * @property string $news_title
 * @property integer $news_user_id
 *
 * @property Country $country
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
            [['news_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['news_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['news_id', 'news_check', 'news_country_id', 'news_date', 'news_user_id'], 'integer'],
            [['news_text', 'news_title'], 'required'],
            [['news_title'], 'string', 'max' => 255],
            [['news_text', 'news_title'], 'trim'],
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
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'news_user_id']);
    }
}
