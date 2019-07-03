<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class OffSeason
 * @package common\models
 *
 * @property int $off_season_id
 * @property int $off_season_difference
 * @property int $off_season_game
 * @property int $off_season_guest
 * @property int $off_season_home
 * @property int $off_season_loose
 * @property int $off_season_loose_overtime
 * @property int $off_season_loose_shootout
 * @property int $off_season_pass
 * @property int $off_season_place
 * @property int $off_season_point
 * @property int $off_season_score
 * @property int $off_season_season_id
 * @property int $off_season_team_id
 * @property int $off_season_win
 * @property int $off_season_win_overtime
 * @property int $off_season_win_shootout
 *
 * @property Team $team
 */
class OffSeason extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%off_season}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'off_season_id',
                    'off_season_difference',
                    'off_season_game',
                    'off_season_guest',
                    'off_season_home',
                    'off_season_loose',
                    'off_season_loose_overtime',
                    'off_season_loose_shootout',
                    'off_season_pass',
                    'off_season_place',
                    'off_season_point',
                    'off_season_score',
                    'off_season_season_id',
                    'off_season_team_id',
                    'off_season_win',
                    'off_season_win_overtime',
                    'off_season_win_shootout',
                ],
                'integer'
            ],
            [['off_season_season_id', 'off_season_team_id'], 'required'],
        ];
    }

    /**
     * @param int $limit
     * @return string
     */
    public function lastGamesShape(int $limit = 5): string
    {
        $result = [];
        $scheduleIdArray = Schedule::find()
            ->select(['schedule_id'])
            ->where([
                'schedule_tournament_type_id' => TournamentType::OFF_SEASON,
                'schedule_season_id' => $this->off_season_season_id,
            ])
            ->column();
        $gameArray = Game::find()
            ->where([
                'or',
                ['game_home_team_id' => $this->off_season_team_id],
                ['game_guest_team_id' => $this->off_season_team_id],
            ])
            ->andWhere(['game_schedule_id' => $scheduleIdArray])
            ->andWhere(['!=', 'game_played', 0])
            ->limit($limit)
            ->all();
        foreach ($gameArray as $game) {
            if ($game->game_home_team_id == $this->off_season_team_id) {
                if ($game->game_home_score > $game->game_guest_score) {
                    $result[] = '<span class="font-green" title="Победа">&bull;</span>';
                } elseif ($game->game_home_score < $game->game_guest_score) {
                    $result[] = '<span class="font-red" title="Поражение">&bull;</span>';
                } else {
                    $result[] = '<span class="font-yellow" title="Ничья/Буллиты">&bull;</span>';
                }
            } else {
                if ($game->game_guest_score > $game->game_home_score) {
                    $result[] = '<span class="font-green" title="Победа">&bull;</span>';
                } elseif ($game->game_guest_score < $game->game_home_score) {
                    $result[] = '<span class="font-red" title="Поражение">&bull;</span>';
                } else {
                    $result[] = '<span class="font-yellow" title="Ничья/Буллиты">&bull;</span>';
                }
            }
        }

        return implode(' ', $result);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'off_season_team_id']);
    }
}
