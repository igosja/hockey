<?php

namespace console\models\generator;

use common\models\Championship;
use common\models\Conference;
use common\models\League;
use common\models\OffSeason;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use common\models\WorldCup;

/**
 * Class StandingPlace
 * @package console\models\generator
 *
 * @property int $seasonId
 */
class StandingPlace
{
    private $seasonId;

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $this->seasonId = Season::getCurrentSeason();

        $scheduleArray = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        foreach ($scheduleArray as $schedule) {
            if (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id) {
                $this->conference();
            } elseif (TournamentType::OFF_SEASON == $schedule->schedule_tournament_type_id) {
                $this->offSeason();
            } elseif (TournamentType::CHAMPIONSHIP == $schedule->schedule_tournament_type_id &&
                $schedule->schedule_stage_id >= Stage::TOUR_1 &&
                $schedule->schedule_stage_id <= Stage::TOUR_30) {
                $this->championship();
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id &&
                $schedule->schedule_stage_id >= Stage::TOUR_LEAGUE_1 &&
                $schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_6) {
                $this->league();
            } elseif (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id) {
                $this->worldCup();
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function conference()
    {
        $conferenceArray = Conference::find()
            ->joinWith(['team'])
            ->where(['conference_season_id' => $this->seasonId])
            ->orderBy([
                'conference_point' => SORT_DESC,
                'conference_win' => SORT_DESC,
                'conference_win_overtime' => SORT_DESC,
                'conference_win_shootout' => SORT_DESC,
                'conference_loose_shootout' => SORT_DESC,
                'conference_loose_overtime' => SORT_DESC,
                'conference_difference' => SORT_DESC,
                'conference_score' => SORT_DESC,
                'team_power_vs' => SORT_ASC,
                'conference_team_id' => SORT_ASC,
            ])
            ->all();
        for ($i = 0, $countConference = count($conferenceArray); $i < $countConference; $i++) {
            $conferenceArray[$i]->conference_place = $i + 1;
            $conferenceArray[$i]->save(false);
        }
    }

    /**
     * @throws \Exception
     */
    private function offSeason()
    {
        $offSeasonArray = OffSeason::find()
            ->joinWith(['team'])
            ->where(['off_season_season_id' => $this->seasonId])
            ->orderBy([
                'off_season_point' => SORT_DESC,
                'off_season_win' => SORT_DESC,
                'off_season_win_overtime' => SORT_DESC,
                'off_season_win_shootout' => SORT_DESC,
                'off_season_loose_shootout' => SORT_DESC,
                'off_season_loose_overtime' => SORT_DESC,
                'off_season_difference' => SORT_DESC,
                'off_season_score' => SORT_DESC,
                'team_power_vs' => SORT_ASC,
                'off_season_team_id' => SORT_ASC,
            ])
            ->all();
        for ($i = 0, $countOffSeason = count($offSeasonArray); $i < $countOffSeason; $i++) {
            $offSeasonArray[$i]->off_season_place = $i + 1;
            $offSeasonArray[$i]->save(false);
        }
    }

    /**
     * @throws \Exception
     */
    private function championship()
    {
        $countryArray = Championship::find()
            ->where(['championship_season_id' => $this->seasonId])
            ->groupBy('championship_country_id')
            ->orderBy(['championship_country_id' => SORT_ASC])
            ->all();
        foreach ($countryArray as $country) {
            $divisionArray = Championship::find()
                ->where([
                    'championship_country_id' => $country->championship_country_id,
                    'championship_season_id' => $this->seasonId,
                ])
                ->groupBy('championship_division_id')
                ->orderBy(['championship_division_id' => SORT_ASC])
                ->all();
            foreach ($divisionArray as $division) {
                $championshipArray = Championship::find()
                    ->joinWith(['team'])
                    ->where([
                        'championship_country_id' => $country->championship_country_id,
                        'championship_division_id' => $division->championship_division_id,
                        'championship_season_id' => $this->seasonId,
                    ])
                    ->orderBy([
                        'championship_point' => SORT_DESC,
                        'championship_win' => SORT_DESC,
                        'championship_win_overtime' => SORT_DESC,
                        'championship_win_shootout' => SORT_DESC,
                        'championship_loose_shootout' => SORT_DESC,
                        'championship_loose_overtime' => SORT_DESC,
                        'championship_difference' => SORT_DESC,
                        'championship_score' => SORT_DESC,
                        'team_power_vs' => SORT_ASC,
                        'championship_team_id' => SORT_ASC,
                    ])
                    ->all();
                for ($i = 0, $countChampionship = count($championshipArray); $i < $countChampionship; $i++) {
                    $championshipArray[$i]->championship_place = $i + 1;
                    $championshipArray[$i]->save();
                }
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function league()
    {
        $groupArray = League::find()
            ->where(['league_season_id' => $this->seasonId])
            ->groupBy('league_group')
            ->orderBy(['league_group' => SORT_ASC])
            ->all();
        foreach ($groupArray as $group) {
            $leagueArray = League::find()
                ->joinWith(['team'])
                ->where([
                    'league_group' => $group->league_group,
                    'league_season_id' => $this->seasonId,
                ])
                ->orderBy([
                    'league_point' => SORT_DESC,
                    'league_win' => SORT_DESC,
                    'league_win_overtime' => SORT_DESC,
                    'league_win_shootout' => SORT_DESC,
                    'league_loose_shootout' => SORT_DESC,
                    'league_loose_overtime' => SORT_DESC,
                    'league_difference' => SORT_DESC,
                    'league_score' => SORT_DESC,
                    'team_power_vs' => SORT_ASC,
                    'league_team_id' => SORT_ASC,
                ])
                ->all();
            for ($i = 0, $countLeague = count($leagueArray); $i < $countLeague; $i++) {
                $leagueArray[$i]->league_place = $i + 1;
                $leagueArray[$i]->save();
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function worldCup()
    {
        $divisionArray = WorldCup::find()
            ->where(['world_cup_season_id' => $this->seasonId])
            ->groupBy('world_cup_division_id')
            ->orderBy(['world_cup_division_id' => SORT_ASC])
            ->all();
        foreach ($divisionArray as $division) {
            $worldCupArray = WorldCup::find()
                ->joinWith(['national'])
                ->where([
                    'world_cup_division_id' => $division->world_cup_division_id,
                    'world_cup_season_id' => $this->seasonId,
                ])
                ->orderBy([
                    'world_cup_point' => SORT_DESC,
                    'world_cup_win' => SORT_DESC,
                    'world_cup_win_overtime' => SORT_DESC,
                    'world_cup_win_shootout' => SORT_DESC,
                    'world_cup_loose_shootout' => SORT_DESC,
                    'world_cup_loose_overtime' => SORT_DESC,
                    'world_cup_difference' => SORT_DESC,
                    'world_cup_score' => SORT_DESC,
                    'national_power_vs' => SORT_ASC,
                    'world_cup_team_id' => SORT_ASC,
                ])
                ->all();
            for ($i = 0, $countWorldCup = count($worldCupArray); $i < $countWorldCup; $i++) {
                $worldCupArray[$i]->world_cup_place = $i + 1;
                $worldCupArray[$i]->save();
            }
        }
    }
}
