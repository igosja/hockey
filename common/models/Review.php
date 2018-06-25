<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Review
 * @package common\models
 *
 * @property integer $review_id
 * @property integer $review_check
 * @property integer $review_country_id
 * @property integer $review_date
 * @property integer $review_division_id
 * @property integer $review_season_id
 * @property integer $review_schedule_id
 * @property integer $review_stage_id
 * @property string $review_text
 * @property string $review_title
 * @property integer $review_user_id
 *
 * @property Country $country
 * @property Division $division
 * @property Stage $stage
 * @property User $user
 */
class Review extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['review_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['review_division_id'], 'in', 'range' => Division::find()->select(['division_id'])->column()],
            [['review_season_id'], 'in', 'range' => Season::find()->select(['season_id'])->column()],
            [['review_stage_id'], 'in', 'range' => Stage::find()->select(['stage_id'])->column()],
            [['review_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [
                [
                    'review_id',
                    'review_check',
                    'review_country_id',
                    'review_date',
                    'review_division_id',
                    'review_season_id',
                    'review_schedule_id',
                    'review_stage_id',
                    'review_text',
                    'review_title',
                    'review_user_id'
                ],
                'integer'
            ],
            [['review_text'], 'safe'],
            [['review_title'], 'string', 'max' => 255],
            [['review_text', 'review_title'], 'trim'],
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
                $this->review_date = time();
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
        return $this->hasOne(Country::class, ['country_id' => 'review_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision(): ActiveQuery
    {
        return $this->hasOne(Division::class, ['division_id' => 'review_division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage(): ActiveQuery
    {
        return $this->hasOne(Stage::class, ['division_id' => 'review_division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'review_user_id']);
    }
}
