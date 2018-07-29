<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class TeamAsk
 * @package common\models
 *
 * @property integer $team_ask_id
 * @property integer $team_ask_date
 * @property integer $team_ask_leave_id
 * @property integer $team_ask_team_id
 * @property integer $team_ask_user_id
 *
 * @property Team $team
 * @property User $user
 */
class TeamAsk extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%team_ask}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['team_ask_leave_id', 'team_ask_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [['team_ask_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['team_ask_id', 'team_ask_date'], 'integer'],
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
                $this->team_ask_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'team_ask_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'team_ask_user_id']);
    }
}
