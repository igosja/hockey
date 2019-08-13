<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class TeamAsk
 * @package common\models
 *
 * @property int $team_ask_id
 * @property int $team_ask_date
 * @property int $team_ask_leave_id
 * @property int $team_ask_team_id
 * @property int $team_ask_user_id
 *
 * @property Recommendation $recommendation
 * @property Team $team
 * @property User $user
 */
class TeamAsk extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName():string
    {
        return '{{%team_ask}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['team_ask_id', 'team_ask_date', 'team_ask_leave_id', 'team_ask_team_id', 'team_ask_user_id'], 'integer'],
            [['team_ask_team_id'], 'required'],
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
                $this->team_ask_date = time();
                if (!$this->team_ask_user_id) {
                    $this->team_ask_user_id = Yii::$app->user->id;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getRecommendation(): ActiveQuery
    {
        return $this->hasOne(
            Recommendation::class,
            ['recommendation_team_id' => 'team_ask_team_id', 'recommendation_user_id' => 'team_ask_user_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'team_ask_team_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'team_ask_user_id'])->cache();
    }
}
