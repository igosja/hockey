<?php

namespace console\models\generator;

use common\models\Championship;
use common\models\Conference;
use common\models\Finance;
use common\models\FinanceText;
use common\models\OffSeason;
use common\models\ParticipantChampionship;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use common\models\WorldCup;
use Exception;

/**
 * Class Prize
 * @package console\models\generator
 */
class Prize
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        $scheduleArray = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->all();

        $seasonId = Season::getCurrentSeason();

        foreach ($scheduleArray as $schedule) {
            if (TournamentType::OFF_SEASON == $schedule->schedule_tournament_type_id && Stage::TOUR_12 == $schedule->schedule_stage_id) {
                $offSeasonArray = OffSeason::find()
                    ->with(['team'])
                    ->where(['off_season_season_id' => $seasonId])
                    ->orderBy(['off_season_id' => SORT_ASC])
                    ->each(5);
                foreach ($offSeasonArray as $offSeason) {
                    /**
                     * @var OffSeason $offSeason
                     */
                    $prize = round(2000000 * pow(0.98, $offSeason->off_season_place - 1));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_OFF_SEASON,
                        'finance_team_id' => $offSeason->off_season_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $offSeason->team->team_finance + $prize,
                        'finance_value_before' => $offSeason->team->team_finance,
                    ]);

                    $offSeason->team->team_finance = $offSeason->team->team_finance + $prize;
                    $offSeason->team->save();
                }
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_33 == $schedule->schedule_stage_id) {
                $championshipArray = ParticipantChampionship::find()
                    ->with(['team'])
                    ->where([
                        'participant_championship_season_id' => $seasonId,
                        'participant_championship_stage_id' => Stage::QUARTER
                    ])
                    ->orderBy(['participant_championship_id' => SORT_ASC])
                    ->each(5);
                foreach ($championshipArray as $championship) {
                    /**
                     * @var ParticipantChampionship $championship
                     */
                    $prize = round(2000000 * pow(0.98, ($championship->participant_championship_division_id - 1) * 16));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_CHAMPIONSHIP,
                        'finance_team_id' => $championship->participant_championship_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $championship->team->team_finance + $prize,
                        'finance_value_before' => $championship->team->team_finance,
                    ]);

                    $championship->team->team_finance = $championship->team->team_finance + $prize;
                    $championship->team->save();
                }
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_36 == $schedule->schedule_stage_id) {
                $championshipArray = ParticipantChampionship::find()
                    ->with(['team'])
                    ->where([
                        'participant_championship_season_id' => $seasonId,
                        'participant_championship_stage_id' => Stage::SEMI
                    ])
                    ->orderBy(['participant_championship_id' => SORT_ASC])
                    ->each(5);
                foreach ($championshipArray as $championship) {
                    /**
                     * @var ParticipantChampionship $championship
                     */
                    $prize = round(3000000 * pow(0.98, ($championship->participant_championship_division_id - 1) * 16));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_CHAMPIONSHIP,
                        'finance_team_id' => $championship->participant_championship_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $championship->team->team_finance + $prize,
                        'finance_value_before' => $championship->team->team_finance,
                    ]);

                    $championship->team->team_finance = $championship->team->team_finance + $prize;
                    $championship->team->save();
                }
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_41 == $schedule->schedule_stage_id) {
                $championshipArray = ParticipantChampionship::find()
                    ->with(['team'])
                    ->where([
                        'participant_championship_season_id' => $seasonId,
                        'participant_championship_stage_id' => [Stage::FINAL_GAME, 0]
                    ])
                    ->orderBy(['participant_championship_id' => SORT_ASC])
                    ->each(5);
                foreach ($championshipArray as $championship) {
                    /**
                     * @var ParticipantChampionship $championship
                     */
                    if (Stage::FINAL_GAME == $championship->participant_championship_stage_id) {
                        $prize = 4000000;
                    } else {
                        $prize = 5000000;
                    }

                    $prize = round($prize * pow(0.98, ($championship->participant_championship_division_id - 1) * 16));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_CHAMPIONSHIP,
                        'finance_team_id' => $championship->participant_championship_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $championship->team->team_finance + $prize,
                        'finance_value_before' => $championship->team->team_finance,
                    ]);

                    $championship->team->team_finance = $championship->team->team_finance + $prize;
                    $championship->team->save();
                }

                $conferenceArray = Conference::find()
                    ->with(['team'])
                    ->where(['conference_season_id' => $seasonId])
                    ->orderBy(['conference_id' => SORT_ASC])
                    ->each(5);
                foreach ($conferenceArray as $conference) {
                    /**
                     * @var Conference $conference
                     */
                    $prize = round(10000000 * pow(0.98, $conference->conference_place - 1));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_CONFERENCE,
                        'finance_team_id' => $conference->conference_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $conference->team->team_finance + $prize,
                        'finance_value_before' => $conference->team->team_finance
                    ]);

                    $conference->team->team_finance = $conference->team->team_finance + $prize;
                    $conference->team->save();
                }
            } elseif (TournamentType::CHAMPIONSHIP == $schedule->schedule_tournament_type_id && Stage::TOUR_30 == $schedule->schedule_stage_id) {
                $championshipArray = Championship::find()
                    ->with(['team'])
                    ->where(['championship_season_id' => $seasonId])
                    ->orderBy(['championship_id' => SORT_ASC])
                    ->each(5);
                foreach ($championshipArray as $championship) {
                    /**
                     * @var Championship $championship
                     */
                    $prize = round(
                        20000000 * pow(
                            0.98,
                            ($championship->championship_place - 1) + ($championship->championship_division_id - 1) * 16
                        )
                    );

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_CHAMPIONSHIP,
                        'finance_team_id' => $championship->championship_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $championship->team->team_finance + $prize,
                        'finance_value_before' => $championship->team->team_finance
                    ]);

                    $championship->team->team_finance = $championship->team->team_finance + $prize;
                    $championship->team->save();
                }
            } elseif (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id && Stage::TOUR_11 == $schedule->schedule_stage_id) {
                $worldCupArray = WorldCup::find()
                    ->with(['national'])
                    ->where(['world_cup_season_id' => $seasonId])
                    ->each(5);
                foreach ($worldCupArray as $worldCup) {
                    /**
                     * @var WorldCup $worldCup
                     */
                    $prize = round((25 - ($worldCup->world_cup_national_type_id - 1) * 5) * 1000000 * pow(0.98, ($worldCup->world_cup_place - 1) + ($worldCup->world_cup_division_id - 1) * 12));

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_WORLD_CUP,
                        'finance_national_id' => $worldCup->world_cup_national_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $worldCup->national->national_finance + $prize,
                        'finance_value_before' => $worldCup->national->national_finance,
                    ]);

                    $worldCup->national->national_finance = $worldCup->national->national_finance + $prize;
                    $worldCup->national->save();
                }
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id && in_array($schedule->schedule_stage_id,
                    [
                        Stage::QUALIFY_1,
                        Stage::QUALIFY_2,
                        Stage::QUALIFY_3,
                        Stage::ROUND_OF_16,
                        Stage::QUARTER,
                        Stage::SEMI
                    ])) {
                $nextStage = Schedule::find()
                    ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")>CURDATE()')
                    ->andWhere(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(1)
                    ->one();
                if ($nextStage->schedule_stage_id != $schedule->schedule_stage_id) {
                    $leagueArray = ParticipantLeague::find()
                        ->with(['team'])
                        ->where([
                            'participant_league_season_id' => $seasonId,
                            'participant_league_stage_id' => $schedule->schedule_stage_id
                        ])
                        ->all();
                    foreach ($leagueArray as $league) {
                        if (Stage::SEMI == $league->participant_league_stage_id) {
                            $prize = 21000000;
                        } elseif (Stage::QUARTER == $league->participant_league_stage_id) {
                            $prize = 19000000;
                        } elseif (Stage::ROUND_OF_16 == $league->participant_league_stage_id) {
                            $prize = 17000000;
                        } elseif (Stage::QUALIFY_3 == $league->participant_league_stage_id) {
                            $prize = 9000000;
                        } elseif (Stage::QUALIFY_2 == $league->participant_league_stage_id) {
                            $prize = 7000000;
                        } else {
                            $prize = 5000000;
                        }

                        Finance::log([
                            'finance_finance_text_id' => FinanceText::INCOME_PRIZE_LEAGUE,
                            'finance_team_id' => $league->participant_league_team_id,
                            'finance_value' => $prize,
                            'finance_value_after' => $league->team->team_finance + $prize,
                            'finance_value_before' => $league->team->team_finance,
                        ]);

                        $league->team->team_finance = $league->team->team_finance + $prize;
                        $league->team->save();
                    }
                }
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id && Stage::TOUR_LEAGUE_6 == $schedule->schedule_stage_id) {
                $leagueArray = ParticipantLeague::find()
                    ->with(['team'])
                    ->where(['participant_league_season_id' => $seasonId, 'participant_league_stage_id' => [3, 4]])
                    ->orderBy(['participant_league_id' => SORT_ASC])
                    ->all();
                foreach ($leagueArray as $league) {
                    if (4 == $league->participant_league_stage_id) {
                        $prize = 13000000;
                    } else {
                        $prize = 15000000;
                    }

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_LEAGUE,
                        'finance_team_id' => $league->participant_league_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $league->team->team_finance + $prize,
                        'finance_value_before' => $league->team->team_finance,
                    ]);

                    $league->team->team_finance = $league->team->team_finance + $prize;
                    $league->team->save();
                }
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id && Stage::FINAL_GAME == $schedule->schedule_stage_id) {
                $nextStage = Schedule::find()
                    ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")>CURDATE()')
                    ->andWhere(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(1)
                    ->one();
                if ($nextStage) {
                    continue;
                }
                $leagueArray = ParticipantLeague::find()
                    ->with(['team'])
                    ->where([
                        'participant_league_season_id' => $seasonId,
                        'participant_league_stage_id' => [Stage::FINAL_GAME, 0]
                    ])
                    ->all();
                foreach ($leagueArray as $league) {
                    if (Stage::FINAL_GAME == $league->participant_league_stage_id) {
                        $prize = 23000000;
                    } else {
                        $prize = 25000000;
                    }

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_PRIZE_LEAGUE,
                        'finance_team_id' => $league->participant_league_team_id,
                        'finance_value' => $prize,
                        'finance_value_after' => $league->team->team_finance + $prize,
                        'finance_value_before' => $league->team->team_finance,
                    ]);

                    $league->team->team_finance = $league->team->team_finance + $prize;
                    $league->team->save();
                }
            }
        }
    }
}
