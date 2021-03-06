<?php

namespace common\models;

use Exception;
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
 * @property int $history_fire_reason
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
 * @property National $national
 * @property Player $player
 * @property Position $position
 * @property Special $special
 * @property Team $team
 * @property Team $teamTwo
 * @property User $user
 */
class History extends AbstractActiveRecord
{
    const FIRE_REASON_SELF = 1;
    const FIRE_REASON_AUTO = 2;
    const FIRE_REASON_ABSENCE = 3;
    const FIRE_REASON_PENALTY = 4;
    const FIRE_REASON_EXTRA_TEAM = 5;
    const FIRE_REASON_NEW_SEASON = 6;
    const FIRE_REASON_VOTE = 7;

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
     * @return bool
     * @throws Exception
     */
    public static function log(array $data): bool
    {
        $history = new self();
        $history->setAttributes($data);
        return $history->save();
    }

    /**
     * @return string
     */
    public function text(): string
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
        if (false !== strpos($text, '{national}')) {
            $text = str_replace(
                '{national}',
                $this->national->nationalLink(),
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
                    Html::encode($this->user->user_login),
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
        if (false !== strpos($text, '{position}')) {
            $text = str_replace(
                '{position}',
                $this->position->position_text,
                $text
            );
        }
        if (false !== strpos($text, '{special}')) {
            $text = str_replace(
                '{special}',
                $this->special->special_text,
                $text
            );
        }
        if (false !== strpos($text, '{building}')) {
            $building = '';
            if (Building::BASE == $this->history_building_id) {
                $building = '????????';
            } elseif (Building::MEDICAL == $this->history_building_id) {
                $building = '????????????????';
            } elseif (Building::PHYSICAL == $this->history_building_id) {
                $building = '?????????? ??????????????????????????';
            } elseif (Building::SCHOOL == $this->history_building_id) {
                $building = '????????????????????';
            } elseif (Building::SCOUT == $this->history_building_id) {
                $building = '??????????-??????????';
            } elseif (Building::TRAINING == $this->history_building_id) {
                $building = '?????????????????????????? ??????????';
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
            $this->history_value . ' ????.',
            $text
        );
        return $text;
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'history_country_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getGame(): ActiveQuery
    {
        return $this->hasOne(Game::class, ['game_id' => 'history_game_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getHistoryText(): ActiveQuery
    {
        return $this->hasOne(HistoryText::class, ['history_text_id' => 'history_history_text_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'history_national_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'history_player_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'history_position_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'history_special_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'history_team_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamTwo(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'history_team_2_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'history_user_id'])->cache();
    }
}
