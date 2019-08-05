<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Conference
 * @package common\models
 *
 * @property int $conference_id
 * @property int $conference_difference
 * @property int $conference_game
 * @property int $conference_guest
 * @property int $conference_home
 * @property int $conference_loose
 * @property int $conference_loose_overtime
 * @property int $conference_loose_shootout
 * @property int $conference_pass
 * @property int $conference_place
 * @property int $conference_point
 * @property int $conference_score
 * @property int $conference_season_id
 * @property int $conference_team_id
 * @property int $conference_win
 * @property int $conference_win_overtime
 * @property int $conference_win_shootout
 *
 * @property Team $team
 */
class Conference extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%conference}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'conference_id',
                    'conference_difference',
                    'conference_game',
                    'conference_guest',
                    'conference_home',
                    'conference_loose',
                    'conference_loose_overtime',
                    'conference_loose_shootout',
                    'conference_pass',
                    'conference_place',
                    'conference_point',
                    'conference_score',
                    'conference_season_id',
                    'conference_team_id',
                    'conference_win',
                    'conference_win_overtime',
                    'conference_win_shootout',
                ],
                'integer'
            ],
            [['conference_season_id', 'conference_team_id'], 'required'],
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
                'schedule_tournament_type_id' => TournamentType::CONFERENCE,
                'schedule_season_id' => $this->conference_season_id,
            ])
            ->column();
        $gameArray = Game::find()
            ->where([
                'or',
                ['game_home_team_id' => $this->conference_team_id],
                ['game_guest_team_id' => $this->conference_team_id],
            ])
            ->andWhere(['game_schedule_id' => $scheduleIdArray])
            ->andWhere(['!=', 'game_played', 0])
            ->orderBy(['game_schedule_id' => SORT_DESC])
            ->limit($limit)
            ->all();
        foreach ($gameArray as $game) {
            if ($game->game_home_team_id == $this->conference_team_id) {
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
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'conference_team_id']);
    }
}
