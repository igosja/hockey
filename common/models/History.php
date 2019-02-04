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
 * @property Country $country
 * @property Game $game
 * @property HistoryText $historyText
 * @property Player $player
 * @property Team $team
 * @property Team $teamTwo
 * @property User $user
 */
class History extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%history}}';
    }

    /**
     * @return array
     */
    public function rules()
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
    public function beforeSave($insert)
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
    public function text()
    {
        $text = $this->historyText->history_text_text;
        if (false !== strpos($text, '{team}')) {
            $text = str_replace(
                '{team}',
                $this->team->teamLink(),
                $text
            );
        }
        if (false !== strpos($text, '{team2}')) {
            $text = str_replace(
                '{team2}',
                $this->teamTwo->teamLink(),
                $text
            );
        }
        if (false !== strpos($text, '{country}')) {
            $text = str_replace(
                '{country}',
                Html::a($this->country->country_name, ['country/news', 'id' => $this->history_country_id]),
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
        if (false !== strpos($text, '{game}')) {
            $text = str_replace(
                '{game}',
                Html::a(
                    $this->game->teamOrNationalLink('home', false, false) . ' - ' . $this->game->teamOrNationalLink('guest', false, false),
                    ['game/view', 'id' => $this->game->game_id]
                ),
                $text
            );
        }
        if (false !== strpos($text, '{building}')) {
            $building = '';
            if (Building::BASE == $this->history_building_id) {
                $building = 'база';
            } elseif (Building::MEDICAL == $this->history_building_id) {
                $building = 'медцентр';
            } elseif (Building::PHYSICAL == $this->history_building_id) {
                $building = 'центр физподготовки';
            } elseif (Building::SCHOOL == $this->history_building_id) {
                $building = 'спортшкола';
            } elseif (Building::SCOUT == $this->history_building_id) {
                $building = 'скаут-центр';
            } elseif (Building::TRAINING == $this->history_building_id) {
                $building = 'тренировочный центр';
            }
            $text = str_replace(
                '{building}',
                $building,
                $text
            );
        }
        $text = str_replace(
            '{capacity}',
            $this->history_value,
            $text
        );
        $text = str_replace(
            '{level}',
            $this->history_value,
            $text
        );
        $text = str_replace(
            '{day}',
            $this->history_value . ' дн.',
            $text
        );
        return $text;
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'history_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::class, ['game_id' => 'history_game_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getHistoryText()
    {
        return $this->hasOne(HistoryText::class, ['history_text_id' => 'history_history_text_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['player_id' => 'history_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'history_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamTwo()
    {
        return $this->hasOne(Team::class, ['team_id' => 'history_team_2_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'history_user_id']);
    }
}
