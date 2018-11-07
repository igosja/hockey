<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * Class History
 * @package common\models
 *
 * @property int $history_id
 * @property int $history_building_id
 * @property int $history_country_id
 * @property int $history_date
 * @property int $history_game_id
 * @property int $history_history_text_id
 * @property int $history_national_id
 * @property int $history_player_id
 * @property int $history_position_id
 * @property int $history_season_id
 * @property int $history_special_id
 * @property int $history_team_id
 * @property int $history_team_2_id
 * @property int $history_user_id
 * @property int $history_user_2_id
 * @property int $history_value
 *
 * @property HistoryText $historyText
 * @property Player $player
 * @property Team $team
 * @property User $user
 */
class History extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'history_id',
                    'history_building_id',
                    'history_country_id',
                    'history_date',
                    'history_game_id',
                    'history_history_text_id',
                    'history_national_id',
                    'history_player_id',
                    'history_position_id',
                    'history_season_id',
                    'history_special_id',
                    'history_team_id',
                    'history_team_2_id',
                    'history_user_id',
                    'history_user_2_id',
                    'history_value',
                ],
                'integer'
            ],
            [['history_history_text_id'], 'required']
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
                $this->history_season_id = Season::getCurrentSeason();
                $this->history_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public static function log(array $data)
    {
        $history = new self();
        $history->setAttributes($data);
        $history->save();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        $text = $this->historyText->history_text_text;
        if (false !== strpos($text, '{team}')) {
            $text = str_replace(
                '{team}',
                Html::a($this->team->team_name, ['team/view', 'id' => $this->history_team_id]),
                $text
            );
        }
        if (false !== strpos($text, '{player}')) {
            $text = str_replace(
                '{player}',
                Html::a(
                    $this->player->name->name_name . ' ' . $this->player->surname->surname_name,
                    ['player/view', 'id' => $this->history_player_id]
                ),
                $text
            );
        }
        if (false !== strpos($text, '{user}')) {
            $text = str_replace(
                '{user}',
                Html::a(
                    $this->user->user_login,
                    ['user/view', 'id' => $this->history_user_id]
                ),
                $text
            );
        }
        return $text;
    }

    /**
     * @return ActiveQuery
     */
    public function getHistoryText(): ActiveQuery
    {
        return $this->hasOne(HistoryText::class, ['history_text_id' => 'history_history_text_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'history_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'history_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'history_user_id']);
    }
}
