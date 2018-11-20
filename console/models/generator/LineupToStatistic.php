<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Position;
use common\models\Stage;
use common\models\StatisticPlayer;
use common\models\TournamentType;

/**
 * Class LineupToStatistic
 * @package console\models\generator
 */
class LineupToStatistic
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['schedule', 'teamHome', 'teamHome.championship', 'nationalHome', 'nationalHome.worldCup', 'lineup'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $countryId = $game->teamHome->championship->championship_country_id ?? 0;
            $divisionId = $game->teamHome->championship->championship_division_id ?? 0;

            if (TournamentType::NATIONAL == $game->schedule->schedule_tournament_type_id) {
                $divisionId = $game->nationalHome->worldCup->world_cup_division_id ?? 0;
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

            foreach ($game->lineup as $lineup) {
                if (Position::GK == $lineup->lineup_position_id) {
                    $isGk = 1;
                } else {
                    $isGk = 0;
                }

                $check = StatisticPlayer::find()->where([
                    'statistic_player_championship_playoff' => $isPlayoff,
                    'statistic_player_country_id' => $countryId,
                    'statistic_player_division_id' => $divisionId,
                    'statistic_player_is_gk' => $isGk,
                    'statistic_player_national_id' => $lineup->lineup_national_id,
                    'statistic_player_player_id' => $lineup->lineup_player_id,
                    'statistic_player_season_id' => $game->schedule->schedule_season_id,
                    'statistic_player_team_id' => $lineup->lineup_team_id,
                    'statistic_player_tournament_type_id' => $game->schedule->schedule_tournament_type_id,
                ])->count();

                if (!$check) {
                    $model = new StatisticPlayer();
                    $model->statistic_player_championship_playoff = $isPlayoff;
                    $model->statistic_player_country_id = $countryId;
                    $model->statistic_player_division_id = $divisionId;
                    $model->statistic_player_is_gk = $divisionId;
                    $model->statistic_player_national_id = $lineup->lineup_national_id;
                    $model->statistic_player_player_id = $lineup->lineup_player_id;
                    $model->statistic_player_season_id = $game->schedule->schedule_season_id;
                    $model->statistic_player_team_id = $lineup->lineup_team_id;
                    $model->statistic_player_tournament_type_id = $game->schedule->schedule_tournament_type_id;
                    $model->save();
                }
            }
        }
    }
}