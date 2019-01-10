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
 * @property Mood $moodGuest
 * @property Mood $moodHome
 * @property National $nationalGuest
 * @property National $nationalHome
 * @property Rudeness $rudenessGuest1
 * @property Rudeness $rudenessGuest2
 * @property Rudeness $rudenessGuest3
 * @property Rudeness $rudenessGuest4
 * @property Rudeness $rudenessHome1
 * @property Rudeness $rudenessHome2
 * @property Rudeness $rudenessHome3
 * @property Rudeness $rudenessHome4
 * @property Schedule $schedule
 * @property Stadium $stadium
 * @property Style $styleGuest1
 * @property Style $styleGuest2
 * @property Style $styleGuest3
 * @property Style $styleGuest4
 * @property Style $styleHome1
 * @property Style $styleHome2
 * @property Style $styleHome3
 * @property Style $styleHome4
 * @property Tactic $tacticGuest1
 * @property Tactic $tacticGuest2
 * @property Tactic $tacticGuest3
 * @property Tactic $tacticGuest4
 * @property Tactic $tacticHome1
 * @property Tactic $tacticHome2
 * @property Tactic $tacticHome3
 * @property Tactic $tacticHome4
 * @property Team $teamGuest
 * @property Team $teamHome
 */
class Game extends AbstractActiveRecord
{
    const TICKET_PRICE_BASE = 9;
    const TICKET_PRICE_DEFAULT = 20;
    const TICKET_PRICE_MAX = 50;
    const TICKET_PRICE_MIN = 10;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @return array
     */
    public function rules()
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

    public function tournamentLink()
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
    public function cssMood($team)
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
    public function cssStyle($team, $id)
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
     * @param string $first
     * @return string
     */
    public function formatScore($first = 'home')
    {
        if ($this->game_played) {
            if ('home' == $first) {
                return $this->game_home_score . ':' . $this->game_guest_score;
            } else {
                return $this->game_guest_score . ':' . $this->game_home_score;
            }
        } else {
            return '?:?';
        }
    }

    /**
     * @param string $side
     * @param bool $full
     * @param bool $link
     * @return string
     */
    public function teamOrNationalLink($side = 'home', $full = true, $link = true)
    {
        if ('home' == $side) {
            $team = $this->teamHome;
            $national = $this->nationalHome;
        } else {
            $team = $this->teamGuest;
            $national = $this->nationalGuest;
        }
        if ($team) {
            $name = $team->team_name;

            if (true == $full) {
                $name = $name . ' ' . Html::tag(
                        'span',
                        '(' . $team->stadium->city->city_name . ', ' . $team->stadium->city->country->country_name . ')',
                        ['class' => 'hidden-xs']
                    );
            }

            if (true == $link) {
                return Html::a($name, ['team/view', 'id' => $team->team_id]);
            } else {
                return $name;
            }
        } elseif ($national) {
            $name = $national->country->country_name;

            if ($full) {
                $name = $name . ' ' . Html::tag(
                        'span',
                        '(' . $national->nationalType->national_type_name . ')',
                        ['class' => 'hidden-xs']
                    );
            }

            if (true == $link) {
                return Html::a($name, ['national/view', 'id' => $national->national_id]);
            } else {
                return $name;
            }
        }

        return '';
    }

    /**
     * @return ActiveQuery
     */
    public function getLineup()
    {
        return $this->hasMany(Lineup::class, ['lineup_game_id' => 'game_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMoodGuest()
    {
        return $this->hasOne(Mood::class, ['mood_id' => 'game_guest_mood_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMoodHome()
    {
        return $this->hasOne(Mood::class, ['mood_id' => 'game_home_mood_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalGuest()
    {
        return $this->hasOne(National::class, ['national_id' => 'game_guest_national_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalHome()
    {
        return $this->hasOne(National::class, ['national_id' => 'game_home_national_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessGuest1()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_guest_rudeness_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessGuest2()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_guest_rudeness_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessGuest3()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_guest_rudeness_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessGuest4()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_guest_rudeness_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessHome1()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_home_rudeness_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessHome2()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_home_rudeness_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessHome3()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_home_rudeness_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRudenessHome4()
    {
        return $this->hasOne(Rudeness::class, ['rudeness_id' => 'game_home_rudeness_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::class, ['schedule_id' => 'game_schedule_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium()
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'game_stadium_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleGuest1()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_guest_style_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleGuest2()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_guest_style_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleGuest3()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_guest_style_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleGuest4()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_guest_style_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleHome1()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_home_style_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleHome2()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_home_style_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleHome3()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_home_style_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStyleHome4()
    {
        return $this->hasOne(Style::class, ['style_id' => 'game_home_style_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticGuest1()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_guest_tactic_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticGuest2()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_guest_tactic_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticGuest3()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_guest_tactic_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticGuest4()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_guest_tactic_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticHome1()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_home_tactic_id_1']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticHome2()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_home_tactic_id_2']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticHome3()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_home_tactic_id_3']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTacticHome4()
    {
        return $this->hasOne(Tactic::class, ['tactic_id' => 'game_home_tactic_id_4']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamGuest()
    {
        return $this->hasOne(Team::class, ['team_id' => 'game_guest_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamHome()
    {
        return $this->hasOne(Team::class, ['team_id' => 'game_home_team_id']);
    }
}
