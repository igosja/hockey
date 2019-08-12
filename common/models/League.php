<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class League
 * @package common\models
 *
 * @property int $league_id
 * @property int $league_difference
 * @property int $league_game
 * @property int $league_group
 * @property int $league_loose
 * @property int $league_loose_overtime
 * @property int $league_loose_shootout
 * @property int $league_pass
 * @property int $league_place
 * @property int $league_point
 * @property int $league_score
 * @property int $league_season_id
 * @property int $league_team_id
 * @property int $league_win
 * @property int $league_win_overtime
 * @property int $league_win_shootout
 *
 * @property Team $team
 */
class League extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'league_id',
                    'league_difference',
                    'league_game',
                    'league_group',
                    'league_loose',
                    'league_loose_overtime',
                    'league_loose_shootout',
                    'league_pass',
                    'league_place',
                    'league_point',
                    'league_score',
                    'league_season_id',
                    'league_team_id',
                    'league_win',
                    'league_win_overtime',
                    'league_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'league_season_id',
                    'league_team_id'
                ],
                'required'
            ],
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
                'schedule_tournament_type_id' => TournamentType::LEAGUE,
                'schedule_season_id' => $this->league_season_id,
            ])
            ->andWhere([
                'schedule_stage_id' => [
                    Stage::TOUR_LEAGUE_1,
                    Stage::TOUR_LEAGUE_2,
                    Stage::TOUR_LEAGUE_3,
                    Stage::TOUR_LEAGUE_4,
                    Stage::TOUR_LEAGUE_5,
                    Stage::TOUR_LEAGUE_6,
                ]
            ])
            ->column();
        $gameArray = Game::find()
            ->where([
                'or',
                ['game_home_team_id' => $this->league_team_id],
                ['game_guest_team_id' => $this->league_team_id],
            ])
            ->andWhere(['game_schedule_id' => $scheduleIdArray])
            ->andWhere(['!=', 'game_played', 0])
            ->limit($limit)
            ->all();
        foreach ($gameArray as $game) {
            if ($game->game_home_team_id == $this->league_team_id) {
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

        return implode('', $result);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'league_team_id'])->cache();
    }
}
