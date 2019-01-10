<?php

namespace common\models;

/**
 * Class Review
 * @package common\models
 *
 * @property int $review_id
 * @property int $review_check
 * @property int $review_country_id
 * @property int $review_date
 * @property int $review_division_id
 * @property int $review_season_id
 * @property int $review_schedule_id
 * @property int $review_stage_id
 * @property string $review_text
 * @property string $review_title
 * @property int $review_user_id
 *
 * @property Country $country
 * @property Division $division
 * @property Stage $stage
 * @property User $user
 */
class Review extends AbstractActiveRecord
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
    public function rules()
    {
        return [
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
                    'review_user_id',
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
    public function beforeSave($insert)
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
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'review_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::class, ['division_id' => 'review_division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::class, ['division_id' => 'review_division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'review_user_id']);
    }
}
