<?php

namespace console\models\generator;

use common\components\HockeyHelper;
use common\models\National;
use common\models\News;
use common\models\PreNews;
use common\models\Schedule;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;
use common\models\User;
use Yii;

/**
 * Class InsertNews
 * @package console\models\generator
 */
class InsertNews
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $todayArray = Schedule::find()
            ->with(['stage'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        $today = $this->text($todayArray);

        $tomorrowArray = Schedule::find()
            ->with(['stage'])
            ->where('FROM_UNIXTIME(`schedule_date`-86400, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        $tomorrow = $this->text($tomorrowArray);

        $day = date('w', strtotime('+1day'));

        if (0 == $day) {
            $day = 'воскресенье';
        } elseif (1 == $day) {
            $day = 'понедельник';
        } elseif (2 == $day) {
            $day = 'вторник';
        } elseif (3 == $day) {
            $day = 'среду';
        } elseif (4 == $day) {
            $day = 'четверг';
        } elseif (5 == $day) {
            $day = 'пятницу';
        } else {
            $day = 'субботу';
        }

        $title = 'Вести с арен';
        $text = '';

        if ($today) {
            $text = $text . '<p class="strong">СЕГОДНЯ</p>' . "\r\n" . '<p>Сегодня состоялись ' . $today . '.</p>' . "\r\n";

            $sql = "SELECT `game_id`,
                           `game_guest_score`,
                           `game_home_score`,
                           `guest_city`.`city_name` AS `guest_city_name`,
                           `guest_country`.`country_name` AS `guest_country_name`,
                           `guest_national`.`national_id` AS `guest_national_id`,
                           `guest_team`.`team_id` AS `guest_team_id`,
                           `guest_team`.`team_name` AS `guest_team_name`,
                           `home_city`.`city_name` AS `home_city_name`,
                           `home_country`.`country_name` AS `home_country_name`,
                           `home_national`.`national_id` AS `home_national_id`,
                           `home_team`.`team_id` AS `home_team_id`,
                           `home_team`.`team_name` AS `home_team_name`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `team` AS `home_team`
                ON `game_home_team_id`=`home_team`.`team_id`
                LEFT JOIN `stadium` AS `home_stadium`
                ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                LEFT JOIN `city` AS `home_city`
                ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                LEFT JOIN `team` AS `guest_team`
                ON `game_guest_team_id`=`guest_team`.`team_id`
                LEFT JOIN `stadium` AS `guest_stadium`
                ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                LEFT JOIN `city` AS `guest_city`
                ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                LEFT JOIN `national` AS `home_national`
                ON `game_home_national_id`=`home_national`.`national_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_national`.`national_country_id`=`home_country`.`country_id`
                LEFT JOIN `national` AS `guest_national`
                ON `game_guest_national_id`=`guest_national`.`national_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                ORDER BY `game_guest_score`+`game_home_score` DESC
                LIMIT 1";
            $result = Yii::$app->db->createCommand($sql)->queryOne();

            if ($result) {
                $text = $text . '<p>Самый крупный счёт в этот день был зафиксирован в матче ' . HockeyHelper::teamOrNationalLink(
                        Team::findOne($result['home_team_id']),
                        National::findOne($result['home_national_id']),
                        false
                    ) . ' - ' . HockeyHelper::teamOrNationalLink(
                        Team::findOne($result['guest_team_id']),
                        National::findOne($result['guest_national_id']),
                        false
                    ) . ' - <a href="/game_view.php?num=' . $result['game_id'] . '">' . $result['game_home_score'] . ':' . $result['game_guest_score'] . '</a>.</p>' . "\r\n";
            }

            $sql = "SELECT `game_id`,
                           `game_guest_score`,
                           `game_home_score`,
                           `guest_city`.`city_name` AS `guest_city_name`,
                           `guest_country`.`country_name` AS `guest_country_name`,
                           `guest_national`.`national_id` AS `guest_national_id`,
                           `guest_team`.`team_id` AS `guest_team_id`,
                           `guest_team`.`team_name` AS `guest_team_name`,
                           `home_city`.`city_name` AS `home_city_name`,
                           `home_country`.`country_name` AS `home_country_name`,
                           `home_national`.`national_id` AS `home_national_id`,
                           `home_team`.`team_id` AS `home_team_id`,
                           `home_team`.`team_name` AS `home_team_name`
                    FROM `game`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    LEFT JOIN `team` AS `home_team`
                    ON `game_home_team_id`=`home_team`.`team_id`
                    LEFT JOIN `stadium` AS `home_stadium`
                    ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `home_city`
                    ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                    LEFT JOIN `team` AS `guest_team`
                    ON `game_guest_team_id`=`guest_team`.`team_id`
                    LEFT JOIN `stadium` AS `guest_stadium`
                    ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `guest_city`
                    ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                    LEFT JOIN `national` AS `home_national`
                    ON `game_home_national_id`=`home_national`.`national_id`
                    LEFT JOIN `country` AS `home_country`
                    ON `home_national`.`national_country_id`=`home_country`.`country_id`
                    LEFT JOIN `national` AS `guest_national`
                    ON `game_guest_national_id`=`guest_national`.`national_id`
                    LEFT JOIN `country` AS `guest_country`
                    ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                    ORDER BY `game_guest_power`+`game_home_power` DESC
                    LIMIT 1";
            $result = Yii::$app->db->createCommand($sql)->queryOne();

            if ($result) {
                $text = $text . '<p>Самую большую суммарную силу соперников зрители могли увидеть в матче ' . HockeyHelper::teamOrNationalLink(
                        Team::findOne($result['home_team_id']),
                        National::findOne($result['home_national_id']),
                        false
                    ) . ' - ' . HockeyHelper::teamOrNationalLink(
                        Team::findOne($result['guest_team_id']),
                        National::findOne($result['guest_national_id']),
                        false
                    ) . ' - <a href="/game_view.php?num=' . $result['game_id'] . '">' . $result['game_home_score'] . ':' . $result['game_guest_score'] . '</a>.</p>' . "\r\n";
            }
        }

        if ($tomorrow) {
            $text = $text . '<p class="strong">ЗАВТРА ДНЁМ</p>' . "\r\n" . '<p>В ' . $day . ' в Лиге будут сыграны ' . $tomorrow . '.</p>' . "\r\n";
        }

        $preNews = PreNews::find()
            ->where(['pre_news_id' => 1])
            ->one();
        if ($preNews->pre_news_error) {
            $text = $text . '<p class="strong">РАБОТА НАД ОШИКАМИ</p>' . "\r\n" . $preNews->pre_news_error . "\r\n";
        }

        if ($preNews->pre_news_new) {
            $text = $text . '<p class="strong">НОВОЕ НА САЙТЕ</p>' . "\r\n" . $preNews->pre_news_new . "\r\n";
        }

        $preNews->pre_news_error = '';
        $preNews->pre_news_new = '';
        $preNews->save();

        $model = new News();
        $model->news_text = $text;
        $model->news_title = $title;
        $model->news_user_id = User::ADMIN_USER_ID;
        $model->save();
    }

    /**
     * @param Schedule[] $scheduleArray
     * @return string
     */
    private function text(array $scheduleArray): string
    {
        $result = [];

        foreach ($scheduleArray as $schedule) {
            if (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id) {
                $result[] = $schedule->stage->stage_name . 'а Чемпионата мира среди сборных';
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id) {
                if ($schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_1 && $schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_6) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . 'а Лиги чемпионов';
                } elseif ($schedule->schedule_stage_id < Stage::QUARTER) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . ' Лиги чемпионов';
                } elseif ($schedule->schedule_stage_id < Stage::FINAL) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . ' финала Лиги чемпионов';
                } elseif (Stage::FINAL == $schedule->schedule_stage_id) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . 'а Лиги чемпионов';
                }
            } elseif (TournamentType::CHAMPIONSHIP == $schedule->schedule_tournament_type_id) {
                if ($schedule->schedule_stage_id <= Stage::TOUR_30) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . 'а национальных чемпионатов';
                } elseif ($schedule->schedule_stage_id <= Stage::FINAL) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . ' финала национальных чемпионатов';
                } elseif (Stage::FINAL == $schedule->schedule_stage_id) {
                    $result[] = 'матчи ' . $schedule->stage->stage_name . 'а национальных чемпионатов';
                }
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id) {
                $result[] = 'матчи ' . $schedule->stage->stage_name . 'а конференции любительских клубов';
            } elseif (TournamentType::OFF_SEASON == $schedule->schedule_tournament_type_id) {
                $result[] = 'матчи ' . $schedule->stage->stage_name . 'а кубка межсезонья';
            } elseif (TournamentType::FRIENDLY == $schedule->schedule_tournament_type_id) {
                $result[] = 'товарищеские матчи';
            }
        }

        $result = implode(' и ', $result);

        return $result;
    }
}
