<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Stage;
use common\models\StatisticTeam;
use common\models\TournamentType;

/**
 * Class TeamToStatistic
 * @package console\models\generator
 */
class TeamToStatistic
{
    /**
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $countryId = $game->teamHome->championship->country->country_id ?? 0;
            $divisionId = $game->teamHome->championship->division->division_id ?? 0;

            if (TournamentType::NATIONAL == $game->schedule->tournamentType->tournament_type_id) {
                $divisionId = $game->nationalHome->worldCup->division->division_id ?? 0;
            }

            if (in_array($game->schedule->tournamentType->tournament_type_id, [
                TournamentType::FRIENDLY,
                TournamentType::CONFERENCE,
                TournamentType::LEAGUE,
                TournamentType::OFF_SEASON
            ])) {
                $countryId = 0;
                $divisionId = 0;
            }

            if (TournamentType::CHAMPIONSHIP == $game->schedule->tournamentType->tournament_type_id && $game->schedule->stage->stage_id >= Stage::QUARTER) {
                $isPlayoff = 1;
            } else {
                $isPlayoff = 0;
            }

            $check = StatisticTeam::find()->where([
                'statistic_team_championship_playoff' => $isPlayoff,
                'statistic_team_country_id' => $countryId,
                'statistic_team_division_id' => $divisionId,
                'statistic_team_national_id' => $game->game_home_national_id,
                'statistic_team_season_id' => $game->schedule->season->season_id,
                'statistic_team_team_id' => $game->game_home_team_id,
                'statistic_team_tournament_type_id' => $game->schedule->tournamentType->tournament_type_id,
            ])->count();

            if (!$check) {
                $model = new StatisticTeam();
                $model->statistic_team_championship_playoff = $isPlayoff;
                $model->statistic_team_country_id = $countryId;
                $model->statistic_team_division_id = $divisionId;
                $model->statistic_team_national_id = $game->game_home_national_id;
                $model->statistic_team_season_id = $game->schedule->season->season_id;
                $model->statistic_team_team_id = $game->game_home_team_id;
                $model->statistic_team_tournament_type_id = $game->schedule->tournamentType->tournament_type_id;
                $model->save();
            }

            $check = StatisticTeam::find()->where([
                'statistic_team_championship_playoff' => $isPlayoff,
                'statistic_team_country_id' => $countryId,
                'statistic_team_division_id' => $divisionId,
                'statistic_team_national_id' => $game->game_guest_national_id,
                'statistic_team_season_id' => $game->schedule->season->season_id,
                'statistic_team_team_id' => $game->game_guest_team_id,
                'statistic_team_tournament_type_id' => $game->schedule->tournamentType->tournament_type_id,
            ])->count();

            if (!$check) {
                $model = new StatisticTeam();
                $model->statistic_team_championship_playoff = $isPlayoff;
                $model->statistic_team_country_id = $countryId;
                $model->statistic_team_division_id = $divisionId;
                $model->statistic_team_national_id = $game->game_guest_national_id;
                $model->statistic_team_season_id = $game->schedule->season->season_id;
                $model->statistic_team_team_id = $game->game_guest_team_id;
                $model->statistic_team_tournament_type_id = $game->schedule->tournamentType->tournament_type_id;
                $model->save();
            }
        }
    }
}