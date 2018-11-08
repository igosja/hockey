<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * Class Game
 * @package common\models
 *
 * @property int $game_id
 * @property int $game_bonus_home
 * @property int $game_guest_auto
 * @property int $game_guest_collision_1
 * @property int $game_guest_collision_2
 * @property int $game_guest_collision_3
 * @property int $game_guest_collision_4
 * @property int $game_guest_forecast
 * @property int $game_guest_mood_id
 * @property int $game_guest_national_id
 * @property int $game_guest_optimality_1
 * @property int $game_guest_optimality_2
 * @property int $game_guest_penalty
 * @property int $game_guest_penalty_1
 * @property int $game_guest_penalty_2
 * @property int $game_guest_penalty_3
 * @property int $game_guest_penalty_overtime
 * @property int $game_guest_plus_minus
 * @property float $game_guest_plus_minus_competition
 * @property float $game_guest_plus_minus_mood
 * @property float $game_guest_plus_minus_optimality_1
 * @property float $game_guest_plus_minus_optimality_2
 * @property float $game_guest_plus_minus_power
 * @property float $game_guest_plus_minus_score
 * @property int $game_guest_power
 * @property int $game_guest_power_percent
 * @property int $game_guest_rudeness_id_1
 * @property int $game_guest_rudeness_id_2
 * @property int $game_guest_rudeness_id_3
 * @property int $game_guest_rudeness_id_4
 * @property int $game_guest_score
 * @property int $game_guest_score_1
 * @property int $game_guest_score_2
 * @property int $game_guest_score_3
 * @property int $game_guest_score_overtime
 * @property int $game_guest_score_shootout
 * @property int $game_guest_shot
 * @property int $game_guest_shot_1
 * @property int $game_guest_shot_2
 * @property int $game_guest_shot_3
 * @property int $game_guest_shot_overtime
 * @property int $game_guest_style_id_1
 * @property int $game_guest_style_id_2
 * @property int $game_guest_style_id_3
 * @property int $game_guest_style_id_4
 * @property int $game_guest_tactic_id_1
 * @property int $game_guest_tactic_id_2
 * @property int $game_guest_tactic_id_3
 * @property int $game_guest_tactic_id_4
 * @property int $game_guest_team_id
 * @property float $game_guest_teamwork_1
 * @property float $game_guest_teamwork_2
 * @property float $game_guest_teamwork_3
 * @property float $game_guest_teamwork_4
 * @property int $game_home_auto
 * @property int $game_home_collision_1
 * @property int $game_home_collision_2
 * @property int $game_home_collision_3
 * @property int $game_home_collision_4
 * @property int $game_home_forecast
 * @property int $game_home_mood_id
 * @property int $game_home_national_id
 * @property int $game_home_optimality_1
 * @property int $game_home_optimality_2
 * @property int $game_home_penalty
 * @property int $game_home_penalty_1
 * @property int $game_home_penalty_2
 * @property int $game_home_penalty_3
 * @property int $game_home_penalty_overtime
 * @property int $game_home_plus_minus
 * @property float $game_home_plus_minus_competition
 * @property float $game_home_plus_minus_mood
 * @property float $game_home_plus_minus_optimality_1
 * @property float $game_home_plus_minus_optimality_2
 * @property float $game_home_plus_minus_power
 * @property float $game_home_plus_minus_score
 * @property int $game_home_power
 * @property int $game_home_power_percent
 * @property int $game_home_rudeness_id_1
 * @property int $game_home_rudeness_id_2
 * @property int $game_home_rudeness_id_3
 * @property int $game_home_rudeness_id_4
 * @property int $game_home_score
 * @property int $game_home_score_1
 * @property int $game_home_score_2
 * @property int $game_home_score_3
 * @property int $game_home_score_overtime
 * @property int $game_home_score_shootout
 * @property int $game_home_shot
 * @property int $game_home_shot_1
 * @property int $game_home_shot_2
 * @property int $game_home_shot_3
 * @property int $game_home_shot_overtime
 * @property int $game_home_style_id_1
 * @property int $game_home_style_id_2
 * @property int $game_home_style_id_3
 * @property int $game_home_style_id_4
 * @property int $game_home_tactic_id_1
 * @property int $game_home_tactic_id_2
 * @property int $game_home_tactic_id_3
 * @property int $game_home_tactic_id_4
 * @property int $game_home_team_id
 * @property float $game_home_teamwork_1
 * @property float $game_home_teamwork_2
 * @property float $game_home_teamwork_3
 * @property float $game_home_teamwork_4
 * @property int $game_played
 * @property int $game_ticket
 * @property int $game_schedule_id
 * @property int $game_stadium_capacity
 * @property int $game_stadium_id
 * @property int $game_visitor
 *
 * @property Lineup[] $lineup
 * @property National $nationalGuest
 * @property National $nationalHome
 * @property Schedule $schedule
 * @property Stadium $stadium
 * @property Team $teamGuest
 * @property Team $teamHome
 */
class Game extends AbstractActiveRecord
{
    const PAGE_LIMIT = 50;

    const TICKET_PRICE_BASE = 9;
    const TICKET_PRICE_DEFAULT = 20;
    const TICKET_PRICE_MAX = 50;
    const TICKET_PRICE_MIN = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%game}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'game_id',
                    'game_bonus_home',
                    'game_guest_auto',
                    'game_guest_collision_1',
                    'game_guest_collision_2',
                    'game_guest_collision_3',
                    'game_guest_collision_4',
                    'game_guest_forecast',
                    'game_guest_mood_id',
                    'game_guest_national_id',
                    'game_guest_optimality_1',
                    'game_guest_optimality_2',
                    'game_guest_penalty',
                    'game_guest_penalty_1',
                    'game_guest_penalty_2',
                    'game_guest_penalty_3',
                    'game_guest_penalty_overtime',
                    'game_guest_plus_minus',
                    'game_guest_power',
                    'game_guest_power_percent',
                    'game_guest_rudeness_id_1',
                    'game_guest_rudeness_id_2',
                    'game_guest_rudeness_id_3',
                    'game_guest_rudeness_id_4',
                    'game_guest_score',
                    'game_guest_score_1',
                    'game_guest_score_2',
                    'game_guest_score_3',
                    'game_guest_score_overtime',
                    'game_guest_score_shootout',
                    'game_guest_shot',
                    'game_guest_shot_1',
                    'game_guest_shot_2',
                    'game_guest_shot_3',
                    'game_guest_shot_overtime',
                    'game_guest_style_id_1',
                    'game_guest_style_id_2',
                    'game_guest_style_id_3',
                    'game_guest_style_id_4',
                    'game_guest_tactic_id_1',
                    'game_guest_tactic_id_2',
                    'game_guest_tactic_id_3',
                    'game_guest_tactic_id_4',
                    'game_guest_team_id',
                    'game_home_auto',
                    'game_home_collision_1',
                    'game_home_collision_2',
                    'game_home_collision_3',
                    'game_home_collision_4',
                    'game_home_forecast',
                    'game_home_mood_id',
                    'game_home_national_id',
                    'game_home_optimality_1',
                    'game_home_optimality_2',
                    'game_home_penalty',
                    'game_home_penalty_1',
                    'game_home_penalty_2',
                    'game_home_penalty_3',
                    'game_home_penalty_overtime',
                    'game_home_plus_minus',
                    'game_home_power',
                    'game_home_power_percent',
                    'game_home_rudeness_id_1',
                    'game_home_rudeness_id_2',
                    'game_home_rudeness_id_3',
                    'game_home_rudeness_id_4',
                    'game_home_score',
                    'game_home_score_1',
                    'game_home_score_2',
                    'game_home_score_3',
                    'game_home_score_overtime',
                    'game_home_score_shootout',
                    'game_home_shot',
                    'game_home_shot_1',
                    'game_home_shot_2',
                    'game_home_shot_3',
                    'game_home_shot_overtime',
                    'game_home_style_id_1',
                    'game_home_style_id_2',
                    'game_home_style_id_3',
                    'game_home_style_id_4',
                    'game_home_tactic_id_1',
                    'game_home_tactic_id_2',
                    'game_home_tactic_id_3',
                    'game_home_tactic_id_4',
                    'game_home_team_id',
                    'game_played',
                    'game_ticket',
                    'game_schedule_id',
                    'game_stadium_capacity',
                    'game_stadium_id',
                    'game_visitor',
                ],
                'integer'
            ],
            [
                [
                    'game_guest_plus_minus_competition',
                    'game_guest_plus_minus_mood',
                    'game_guest_plus_minus_optimality_1',
                    'game_guest_plus_minus_optimality_2',
                    'game_guest_plus_minus_power',
                    'game_guest_plus_minus_score',
                    'game_guest_teamwork_1',
                    'game_guest_teamwork_2',
                    'game_guest_teamwork_3',
                    'game_guest_teamwork_4',
                    'game_home_plus_minus_competition',
                    'game_home_plus_minus_mood',
                    'game_home_plus_minus_optimality_1',
                    'game_home_plus_minus_optimality_2',
                    'game_home_plus_minus_power',
                    'game_home_plus_minus_score',
                    'game_home_teamwork_1',
                    'game_home_teamwork_2',
                    'game_home_teamwork_3',
                    'game_home_teamwork_4',
                ],
                'number'
            ],
            [['game_schedule_id'], 'required'],
        ];
    }

    public function tournamentLink(): string
    {
        if (TournamentType::NATIONAL == $this->schedule->schedule_tournament_type_id) {
            $result = Html::a(
                $this->schedule->tournamentType->tournament_type_name . ', ' . $this->schedule->stage->stage_name,
                [
                    'world-cup/table',
                    'seasonId' => $this->schedule->schedule_season_id,
                    'stageId' => $this->schedule->schedule_stage_id,
                ]
            );
        } elseif (TournamentType::LEAGUE == $this->schedule->schedule_tournament_type_id) {
            if ($this->schedule->schedule_stage_id <= Stage::QUALIFY_3) {
                $roundId = 0;
            } elseif ($this->schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_1) {
                $roundId = 1;
            } else {
                $roundId = 2;
            }

            $result = Html::a(
                $this->schedule->tournamentType->tournament_type_name . ', ' . $this->schedule->stage->stage_name,
                [
                    'league/index',
                    'roundId' => $roundId,
                    'seasonId' => $this->schedule->schedule_season_id,
                    'stageId' => $this->schedule->schedule_stage_id,
                ]
            );
        } elseif (TournamentType::CHAMPIONSHIP == $this->schedule->schedule_tournament_type_id) {
            $result = Html::a(
                $this->schedule->tournamentType->tournament_type_name . ', ' . $this->schedule->stage->stage_name,
                [
                    'championship/index',
                    'seasonId' => $this->schedule->schedule_season_id,
                    'divisionId' => $this->teamHome->championship->championship_division_id,
                    'countryId' => $this->teamHome->championship->championship_country_id,
                    'stageId' => $this->schedule->schedule_stage_id,
                ]
            );
        } elseif (TournamentType::CONFERENCE == $this->schedule->schedule_tournament_type_id) {
            $result = Html::a(
                $this->schedule->tournamentType->tournament_type_name . ', ' . $this->schedule->stage->stage_name,
                [
                    'conference/table',
                    'seasonId' => $this->schedule->schedule_season_id,
                ]
            );
        } elseif (TournamentType::OFF_SEASON == $this->schedule->schedule_tournament_type_id) {
            $result = Html::a(
                $this->schedule->tournamentType->tournament_type_name . ', ' . $this->schedule->stage->stage_name,
                [
                    'off-season/table',
                    'seasonId' => $this->schedule->schedule_season_id,
                ]
            );
        } else {
            $result = $this->schedule->tournamentType->tournament_type_name;
        }

        return $result;
    }

    /**
     * @param $team
     * @return string
     */
    public function cssMood($team): string
    {
        $classLoose = 'font-red';
        $classWin = 'font-green';

        $mood = 'game_' . $team . '_mood_id';
        $mood = $this->$mood;

        if (Mood::SUPER == $mood) {
            return $classWin;
        }
        if (Mood::REST == $mood) {
            return $classLoose;
        }
        return '';
    }

    /**
     * @param string $team
     * @param int $id
     * @return string
     */
    public function cssStyle(string $team, int $id): string
    {
        $classLoose = 'font-red';
        $classWin = 'font-green';

        if ('home' == $team) {
            $opponent = 'guest';
        } else {
            $opponent = 'home';
        }

        $style1 = 'game_' . $team . '_style_id_' . $id;
        $style1 = $this->$style1;
        $style2 = 'game_' . $opponent . '_style_id_' . $id;
        $style2 = $this->$style2;

        if (Style::POWER == $style1 && Style::SPEED == $style2) {
            return $classWin;
        }
        if (Style::SPEED == $style1 && Style::TECHNIQUE == $style2) {
            return $classWin;
        }
        if (Style::TECHNIQUE == $style1 && Style::POWER == $style2) {
            return $classWin;
        }
        if (Style::SPEED == $style1 && Style::POWER == $style2) {
            return $classLoose;
        }
        if (Style::TECHNIQUE == $style1 && Style::SPEED == $style2) {
            return $classLoose;
        }
        if (Style::POWER == $style1 && Style::TECHNIQUE == $style2) {
            return $classLoose;
        }
        return '';
    }

    /**
     * @return ActiveQuery
     */
    public function getLineup(): ActiveQuery
    {
        return $this->hasMany(Lineup::class, ['lineup_game_id' => 'game_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalGuest(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'game_guest_national_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalHome(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'game_home_national_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSchedule(): ActiveQuery
    {
        return $this->hasOne(Schedule::class, ['schedule_id' => 'game_schedule_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium(): ActiveQuery
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'game_stadium_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamGuest(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'game_guest_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamHome(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'game_home_team_id']);
    }
}
