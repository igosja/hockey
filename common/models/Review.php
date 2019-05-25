<?php

namespace common\models;

use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;

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
 * @property ReviewGame[] $reviewGame
 * @property ReviewVote[] $reviewVote
 * @property ReviewVote[] $reviewVoteMinus
 * @property ReviewVote[] $reviewVotePlus
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
                $this->review_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->reviewGame as $reviewGame) {
            $reviewGame->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return string
     */
    public function rating()
    {
        $returnArray = [
            '<span class="font-green">' . count($this->reviewVotePlus) . '</span>',
            '<span class="font-red">' . count($this->reviewVoteMinus) . '</span>',
        ];

        $return = implode(' | ', $returnArray);

        return $return;
    }

    /**
     * @return ActiveQuery
     */
    public function getReviewVote()
    {
        return $this->hasMany(ReviewVote::class, ['review_vote_review_id' => 'review_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReviewVoteMinus()
    {
        return $this->getReviewVote()->andWhere(['<', 'review_vote_rating', 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getReviewVotePlus()
    {
        return $this->getReviewVote()->andWhere(['>', 'review_vote_rating', 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'review_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::class, ['division_id' => 'review_division_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReviewGame()
    {
        return $this->hasMany(ReviewGame::class, ['review_game_review_id' => 'review_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::class, ['stage_id' => 'review_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'review_user_id']);
    }
}
