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
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['schedule', 'teamHome', 'nationalHome', 'teamHome.championship', 'nationalHome.worldCup'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each(5);
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $countryId = isset($game->teamHome->championship->championship_country_id) ? $game->teamHome->championship->championship_country_id : 0;
            $divisionId = isset($game->teamHome->championship->championship_division_id) ? $game->teamHome->championship->championship_division_id : 0;

            if (TournamentType::NATIONAL == $game->schedule->schedule_tournament_type_id) {
                $divisionId = isset($game->nationalHome->worldCup->world_cup_division_id) ? $game->nationalHome->worldCup->world_cup_division_id : 0;
            }

            if (in_array($game->schedule->schedule_tournament_type_id, [
                TournamentType::FRIENDLY,
                TournamentType::CONFERENCE,
                TournamentType::LEAGUE,
                TournamentType::OFF_SEASON
            ])) {
                $countryId = 0;
                $divisionId = 0;
            }

            if (TournamentType::CHAMPIONSHIP == $game->schedule->schedule_tournament_type_id && $game->schedule->schedule_stage_id >= Stage::QUARTER) {
                $isPlayoff = 1;
            } else {
                $isPlayoff = 0;
            }

            $check = StatisticTeam::find()->where([
                'statistic_team_championship_playoff' => $isPlayoff,
                'statistic_team_country_id' => $countryId,
                'statistic_team_division_id' => $divisionId,
                'statistic_team_national_id' => $game->game_home_national_id,
                'statistic_team_season_id' => $game->schedule->schedule_season_id,
                'statistic_team_team_id' => $game->game_home_team_id,
                'statistic_team_tournament_type_id' => $game->schedule->schedule_tournament_type_id,
            ])->count();

            if (!$check) {
                $model = new StatisticTeam();
                $model->statistic_team_championship_playoff = $isPlayoff;
                $model->statistic_team_country_id = $countryId;
                $model->statistic_team_division_id = $divisionId;
                $model->statistic_team_national_id = $game->game_home_national_id;
                $model->statistic_team_season_id = $game->schedule->schedule_season_id;
                $model->statistic_team_team_id = $game->game_home_team_id;
                $model->statistic_team_tournament_type_id = $game->schedule->schedule_tournament_type_id;
                $model->save();
            }

            $check = StatisticTeam::find()->where([
                'statistic_team_championship_playoff' => $isPlayoff,
                'statistic_team_country_id' => $countryId,
                'statistic_team_division_id' => $divisionId,
                'statistic_team_national_id' => $game->game_guest_national_id,
                'statistic_team_season_id' => $game->schedule->schedule_season_id,
                'statistic_team_team_id' => $game->game_guest_team_id,
                'statistic_team_tournament_type_id' => $game->schedule->schedule_tournament_type_id,
            ])->count();

            if (!$check) {
                $model = new StatisticTeam();
                $model->statistic_team_championship_playoff = $isPlayoff;
                $model->statistic_team_country_id = $countryId;
                $model->statistic_team_division_id = $divisionId;
                $model->statistic_team_national_id = $game->game_guest_national_id;
                $model->statistic_team_season_id = $game->schedule->schedule_season_id;
                $model->statistic_team_team_id = $game->game_guest_team_id;
                $model->statistic_team_tournament_type_id = $game->schedule->schedule_tournament_type_id;
                $model->save();
            }
        }
    }
}
