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
 * @property Team $team
 * @property User $user
 */
class TeamAsk extends AbstractActiveRecord
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
