<?php

namespace console\models\generator;

use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Yii;

/**
 * Class InsertAchievement
 * @package console\models\generator
 */
class InsertAchievement
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $scheduleArray = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->all();

        $seasonId = Season::getCurrentSeason();

        foreach ($scheduleArray as $schedule) {
            if (TournamentType::OFF_SEASON == $schedule->schedule_tournament_type_id && Stage::TOUR_12 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_place`, `achievement_season_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `off_season_place`, `off_season_season_id`, `team_id`, " . TournamentType::OFF_SEASON . ", `team_user_id`
                        FROM `off_season`
                        LEFT JOIN `team`
                        ON `off_season_team_id`=`team_id`
                        WHERE `off_season_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_place`, `achievement_player_season_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `player_id`, `off_season_place`, `off_season_season_id`, `team_id`, " . TournamentType::OFF_SEASON . "
                        FROM `off_season`
                        LEFT JOIN `team`
                        ON `off_season_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `off_season_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id && Stage::TOUR_11 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_place`, `achievement_season_id`, `achievement_national_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `world_cup_place`, `world_cup_season_id`, `national_id`, " . TournamentType::NATIONAL . ", `national_user_id`
                        FROM `world_cup`
                        LEFT JOIN `national`
                        ON `world_cup_national_id`=`national_id`
                        WHERE `world_cup_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_place`, `achievement_player_season_id`, `achievement_player_national_id`, `achievement_player_tournament_type_id`)
                        SELECT `national_player_day_player_id`, `world_cup_place`, `world_cup_season_id`, `national_player_day_national_id`, " . TournamentType::NATIONAL . "
                        FROM `national_player_day`
                        LEFT JOIN `world_cup`
                        ON `national_player_day_national_id`=`world_cup_national_id`
                        WHERE `world_cup_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_41 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . ", `team_user_id`
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id` IN (" . Stage::FINAL . ", 0)";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_country_id`, `achievement_player_division_id`, `achievement_player_is_playoff`, `achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `player_id`, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . "
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id` IN (" . Stage::FINAL . ", 0)";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement` (`achievement_place`, `achievement_season_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `conference_place`, `conference_season_id`, `team_id`, " . TournamentType::CONFERENCE . ", `team_user_id`
                        FROM `conference`
                        LEFT JOIN `team`
                        ON `conference_team_id`=`team_id`
                        WHERE `conference_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_place`, `achievement_player_season_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `player_id`, `conference_place`, `conference_season_id`, `team_id`, " . TournamentType::CONFERENCE . "
                        FROM `conference`
                        LEFT JOIN `team`
                        ON `conference_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `conference_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::CHAMPIONSHIP == $schedule->schedule_tournament_type_id && Stage::TOUR_30 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_place`, `achievement_season_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `championship_country_id`, `championship_division_id`, `championship_place`, `championship_season_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . ", `team_user_id`
                        FROM `championship`
                        LEFT JOIN `team`
                        ON `championship_team_id`=`team_id`
                        WHERE `championship_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_country_id`, `achievement_player_division_id`, `achievement_player_player_id`, `achievement_player_place`, `achievement_player_season_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `championship_country_id`, `championship_division_id`, `player_id`, `championship_place`, `championship_season_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . "
                        FROM `championship`
                        LEFT JOIN `team`
                        ON `championship_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `championship_season_id`=$seasonId";
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_33 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . ", `team_user_id`
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id`=" . Stage::QUARTER;
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_country_id`, `achievement_player_division_id`, `achievement_player_is_playoff`, `achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `player_id`, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . "
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id`=" . Stage::QUARTER;
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id && Stage::TOUR_36 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_country_id`, `achievement_division_id`, `achievement_is_playoff`, `achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . ", `team_user_id`
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id`=" . Stage::SEMI;
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_country_id`, `achievement_player_division_id`, `achievement_player_is_playoff`, `achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `participant_championship_country_id`, `participant_championship_division_id`, 1, `player_id`, `participant_championship_season_id`, `participant_championship_stage_id`, `team_id`, " . TournamentType::CHAMPIONSHIP . "
                        FROM `participant_championship`
                        LEFT JOIN `team`
                        ON `participant_championship_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_championship_season_id`=$seasonId
                        AND `participant_championship_stage_id`=" . Stage::SEMI;
                Yii::$app->db->createCommand($sql)->execute();
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
                    ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")>CURDATE()')
                    ->andWhere(['!=', 'schedule_stage_id', $schedule->schedule_stage_id])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(1)
                    ->one();
                if (!$nextStage) {
                    continue;
                }

                $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `participant_league_season_id`, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . ", `team_user_id`
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id`=" . $schedule->schedule_stage_id;
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `player_id`, `participant_league_season_id`, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . "
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id`=" . $schedule->schedule_stage_id;
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id && Stage::TOUR_LEAGUE_6 == $schedule->schedule_stage_id) {
                $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_place`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT `participant_league_season_id`, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . ", `team_user_id`
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id` IN (3, 4)";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `player_id`, `participant_league_season_id`, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . "
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id` IN (3, 4)";
                Yii::$app->db->createCommand($sql)->execute();
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id && Stage::FINAL == $schedule->schedule_stage_id) {
                $nextStage = Schedule::find()
                    ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")>CURDATE()')
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(1)
                    ->one();
                if ($nextStage) {
                    continue;
                }

                $sql = "INSERT INTO `achievement` (`achievement_season_id`, `achievement_stage_id`, `achievement_team_id`, `achievement_tournament_type_id`, `achievement_user_id`)
                        SELECT $seasonId, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . ", `team_user_id`
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id` IN (" . Stage::FINAL . ", 0)";
                Yii::$app->db->createCommand($sql)->execute();

                $sql = "INSERT INTO `achievement_player` (`achievement_player_player_id`, `achievement_player_season_id`, `achievement_player_stage_id`, `achievement_player_team_id`, `achievement_player_tournament_type_id`)
                        SELECT `player_id`, $seasonId, `participant_league_stage_id`, `team_id`, " . TournamentType::LEAGUE . "
                        FROM `participant_league`
                        LEFT JOIN `team`
                        ON `participant_league_team_id`=`team_id`
                        LEFT JOIN `player`
                        ON `team_id`=`player_team_id`
                        WHERE `participant_league_season_id`=$seasonId
                        AND `participant_league_stage_id` IN (" . Stage::FINAL . ", 0)";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }
}