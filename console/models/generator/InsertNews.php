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
use yii\helpers\Html;

/**
 * Class InsertNews
 * @package console\models\generator
 */
class InsertNews
{
    /**
     * @throws \Exception
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $todayArray = Schedule::find()
            ->with(['stage'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        $today = $this->text($todayArray, true);

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
            $text = $text . '<p class="strong">СЕГОДНЯ</p>' . "\r\n" . '<p>Сегодня ' . $today . '.</p>' . "\r\n";

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
                    ) . ' - ' . Html::a(
                        $result['game_home_score'] . ':' . $result['game_guest_score'],
                        ['game/view', 'id' => $result['game_id']]
                    ) . '</p>' . "\r\n";
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
                    ) . ' - ' . Html::a(
                        $result['game_home_score'] . ':' . $result['game_guest_score'],
                        ['game/view', 'id' => $result['game_id']]
                    ) . '</p>' . "\r\n";
            }
        }

        if ($tomorrow) {
            $text = $text . '<p class="strong">ЗАВТРА ДНЁМ</p>' . "\r\n" . '<p>В ' . $day . ' в Лиге ' . $tomorrow . '.</p>' . "\r\n";
        }

        $preNews = PreNews::find()
            ->where(['pre_news_id' => 1])
            ->one();
        if ($preNews->pre_news_error) {
            $text = $text . '<p class="strong">РАБОТА НАД ОШИБКАМИ</p>' . "\r\n" . $preNews->pre_news_error . "\r\n";
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
     * @param array $scheduleArray
     * @param bool $today
     * @return string
     */
    private function text(array $scheduleArray, $today = false)
    {
        $result = [];
        if ($today) {
            $before = 'состоялись';
        } else {
            $before = 'будут сыграны';
        }

        foreach ($scheduleArray as $schedule) {
            $stageName = $this->stageName($schedule->schedule_stage_id);
            if (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id) {
                $result[] = 'матчи ' . $stageName . ' Чемпионата мира среди сборных';
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id) {
                if ($schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_1 && $schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_6) {
                    $result[] = 'матчи ' . $stageName . ' Лиги чемпионов';
                } elseif ($schedule->schedule_stage_id < Stage::QUARTER) {
                    $result[] = 'матчи ' . $stageName . ' Лиги чемпионов';
                } elseif ($schedule->schedule_stage_id < Stage::FINAL_GAME) {
                    $result[] = $stageName . ' Лиги чемпионов';
                } elseif (Stage::FINAL_GAME == $schedule->schedule_stage_id) {
                    if ($today) {
                        $before = 'состоялся';
                    } else {
                        $before = 'будет сыгран';
                    }
                    $result[] = $stageName . ' Лиги чемпионов';
                }
            } elseif (TournamentType::CHAMPIONSHIP == $schedule->schedule_tournament_type_id) {
                if ($schedule->schedule_stage_id <= Stage::TOUR_30) {
                    $result[] = 'матчи ' . $stageName . ' национальных чемпионатов';
                } elseif ($schedule->schedule_stage_id <= Stage::FINAL_GAME) {
                    $result[] = $stageName . 'ы национальных чемпионатов';
                } elseif (Stage::FINAL_GAME == $schedule->schedule_stage_id) {
                    $result[] = $stageName . 'ы национальных чемпионатов';
                }
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id) {
                $result[] = 'матчи ' . $stageName . ' конференции любительских клубов';
            } elseif (TournamentType::OFF_SEASON == $schedule->schedule_tournament_type_id) {
                $result[] = 'матчи ' . $stageName . ' кубка межсезонья';
            } elseif (TournamentType::FRIENDLY == $schedule->schedule_tournament_type_id) {
                $result[] = 'товарищеские матчи';
            }
        }

        $result = $before . ' ' . implode(' и ', $result);

        return $result;
    }

    private function stageName($stageId)
    {
        $result = '';
        if (Stage::TOUR_1 == $stageId) {
            $result = '1-го тура';
        } elseif (Stage::TOUR_2 == $stageId) {
            $result = '2-го тура';
        } elseif (Stage::TOUR_3 == $stageId) {
            $result = '3-го тура';
        } elseif (Stage::TOUR_4 == $stageId) {
            $result = '4-го тура';
        } elseif (Stage::TOUR_5 == $stageId) {
            $result = '5-го тура';
        } elseif (Stage::TOUR_6 == $stageId) {
            $result = '6-го тура';
        } elseif (Stage::TOUR_7 == $stageId) {
            $result = '7-го тура';
        } elseif (Stage::TOUR_8 === $stageId) {
            $result = '8-го тура';
        } elseif (Stage::TOUR_9 == $stageId) {
            $result = '9-го тура';
        } elseif (Stage::TOUR_10 == $stageId) {
            $result = '10-го тура';
        } elseif (Stage::TOUR_11 == $stageId) {
            $result = '11-го тура';
        } elseif (Stage::TOUR_12 == $stageId) {
            $result = '12-го тура';
        } elseif (Stage::TOUR_13 == $stageId) {
            $result = '13-го тура';
        } elseif (Stage::TOUR_14 == $stageId) {
            $result = '14-го тура';
        } elseif (Stage::TOUR_15 == $stageId) {
            $result = '15-го тура';
        } elseif (Stage::TOUR_16 == $stageId) {
            $result = '16-го тура';
        } elseif (Stage::TOUR_17 == $stageId) {
            $result = '17-го тура';
        } elseif (Stage::TOUR_18 == $stageId) {
            $result = '18-го тура';
        } elseif (Stage::TOUR_19 == $stageId) {
            $result = '19-го тура';
        } elseif (Stage::TOUR_20 == $stageId) {
            $result = '20-го тура';
        } elseif (Stage::TOUR_21 == $stageId) {
            $result = '21-го тура';
        } elseif (Stage::TOUR_22 == $stageId) {
            $result = '22-го тура';
        } elseif (Stage::TOUR_23 == $stageId) {
            $result = '23-го тура';
        } elseif (Stage::TOUR_24 == $stageId) {
            $result = '24-го тура';
        } elseif (Stage::TOUR_25 == $stageId) {
            $result = '25-го тура';
        } elseif (Stage::TOUR_26 == $stageId) {
            $result = '26-го тура';
        } elseif (Stage::TOUR_27 == $stageId) {
            $result = '27-го тура';
        } elseif (Stage::TOUR_28 == $stageId) {
            $result = '28-го тура';
        } elseif (Stage::TOUR_29 == $stageId) {
            $result = '29-го тура';
        } elseif (Stage::TOUR_30 == $stageId) {
            $result = '30-го тура';
        } elseif (Stage::TOUR_31 == $stageId) {
            $result = '31-го тура';
        } elseif (Stage::TOUR_32 == $stageId) {
            $result = '32-го тура';
        } elseif (Stage::TOUR_33 == $stageId) {
            $result = '33-го тура';
        } elseif (Stage::TOUR_34 == $stageId) {
            $result = '34-го тура';
        } elseif (Stage::TOUR_35 == $stageId) {
            $result = '35-го тура';
        } elseif (Stage::TOUR_36 == $stageId) {
            $result = '36-го тура';
        } elseif (Stage::TOUR_37 == $stageId) {
            $result = '37-го тура';
        } elseif (Stage::TOUR_38 == $stageId) {
            $result = '38-го тура';
        } elseif (Stage::TOUR_39 == $stageId) {
            $result = '39-го тура';
        } elseif (Stage::TOUR_40 == $stageId) {
            $result = '40-го тура';
        } elseif (Stage::TOUR_41 == $stageId) {
            $result = '41-го тура';
        } elseif (Stage::QUALIFY_1 == $stageId) {
            $result = '1-го ОР';
        } elseif (Stage::QUALIFY_2 == $stageId) {
            $result = '2-го ОР';
        } elseif (Stage::QUALIFY_3 == $stageId) {
            $result = '3-го ОР';
        } elseif (Stage::TOUR_LEAGUE_1 == $stageId) {
            $result = '1-го тура';
        } elseif (Stage::TOUR_LEAGUE_2 == $stageId) {
            $result = '2-го тура';
        } elseif (Stage::TOUR_LEAGUE_3 == $stageId) {
            $result = '3-го тура';
        } elseif (Stage::TOUR_LEAGUE_4 == $stageId) {
            $result = '4-го тура';
        } elseif (Stage::TOUR_LEAGUE_5 == $stageId) {
            $result = '5-го тура';
        } elseif (Stage::TOUR_LEAGUE_6 == $stageId) {
            $result = '6-го тура';
        } elseif (Stage::ROUND_OF_16 == $stageId) {
            $result = '1/8 финала';
        } elseif (Stage::QUARTER == $stageId) {
            $result = 'четвертьфиналы';
        } elseif (Stage::SEMI == $stageId) {
            $result = 'полуфиналы';
        } elseif (Stage::FINAL_GAME == $stageId) {
            $result = 'финал';
        }

        return $result;
    }
}
