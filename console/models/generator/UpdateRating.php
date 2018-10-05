<?php

namespace console\models\generator;

use common\models\Country;
use common\models\RatingCountry;
use common\models\RatingTeam;
use common\models\RatingType;
use common\models\RatingUser;
use common\models\Season;
use common\models\Team;
use common\models\User;
use Yii;
use yii\db\Expression;

/**
 * Class UpdateRating
 * @package console\models\generator
 */
class UpdateRating
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();

        Yii::$app->db->createCommand()->truncateTable('rating_country')->execute();
        Yii::$app->db->createCommand()->truncateTable('rating_team')->execute();
        Yii::$app->db->createCommand()->truncateTable('rating_user')->execute();

        $sql = "INSERT INTO `rating_country` (`rating_country_country_id`)
                SELECT `country_id`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `country`
                ON `city_country_id`=`country_id`
                WHERE `team_id`!=0
                GROUP BY `country_id`
                ORDER BY `country_id` ASC";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "INSERT INTO `rating_team` (`rating_team_team_id`)
                SELECT `team_id`
                FROM `team`
                WHERE `team_id`!=0
                ORDER BY `team_id` ASC";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "INSERT INTO `rating_user` (`rating_user_user_id`)
                SELECT `user_id`
                FROM `user`
                LEFT JOIN `team`
                ON `user_id`=`team_user_id`
                WHERE `team_id` IS NOT NULL
                AND `user_id`!=0
                GROUP BY `user_id`
                ORDER BY `user_id` ASC";
        Yii::$app->db->createCommand($sql)->execute();

        $ratingTypeArray = RatingType::find()
            ->orderBy(['rating_type_rating_chapter_id' => SORT_ASC, 'rating_type_id' => SORT_ASC])
            ->each();
        foreach ($ratingTypeArray as $ratingType) {
            /**
             * @var RatingType $ratingType
             */
            if (RatingType::TEAM_POWER == $ratingType->rating_type_id) {
                $order = '`team_power_vs` DESC';
                $place = 'rating_team_power_vs_place';
            } elseif (RatingType::TEAM_AGE == $ratingType->rating_type_id) {
                $order = '`team_age`';
                $place = 'rating_team_age_place';
            } elseif (RatingType::TEAM_STADIUM == $ratingType->rating_type_id) {
                $order = '`team_price_stadium` DESC';
                $place = 'rating_team_stadium_place';
            } elseif (RatingType::TEAM_VISITOR == $ratingType->rating_type_id) {
                $order = '`team_visitor` DESC';
                $place = 'rating_team_visitor_place';
            } elseif (RatingType::TEAM_BASE == $ratingType->rating_type_id) {
                $order = '`team_base_id`+`team_base_medical_id`+`team_base_physical_id`+`team_base_school_id`+`team_base_scout_id`+`team_base_training_id` DESC';
                $place = 'rating_team_base_place';
            } elseif (RatingType::TEAM_PRICE_BASE == $ratingType->rating_type_id) {
                $order = '`team_price_base` DESC';
                $place = 'rating_team_price_base_place';
            } elseif (RatingType::TEAM_PRICE_STADIUM == $ratingType->rating_type_id) {
                $order = '`team_price_stadium` DESC';
                $place = 'rating_team_price_stadium_place';
            } elseif (RatingType::TEAM_PLAYER == $ratingType->rating_type_id) {
                $order = '`team_player` DESC';
                $place = 'rating_team_player_place';
            } elseif (RatingType::TEAM_PRICE_TOTAL == $ratingType->rating_type_id) {
                $order = '`team_price_total` DESC';
                $place = 'rating_team_price_total_place';
            } elseif (RatingType::USER_RATING == $ratingType->rating_type_id) {
                $order = '`user_rating` DESC';
                $place = 'rating_user_rating_place';
            } elseif (RatingType::COUNTRY_STADIUM == $ratingType->rating_type_id) {
                $order = '`country_stadium` DESC';
                $place = 'rating_country_stadium_place';
            } elseif (RatingType::COUNTRY_AUTO == $ratingType->rating_type_id) {
                $order = '`country_auto`/`country_game`';
                $place = 'rating_country_auto_place';
            } elseif (RatingType::COUNTRY_LEAGUE == $ratingType->rating_type_id) {
                $place = 'rating_country_league_place';
            }

            if (in_array($ratingType->rating_type_id, [
                RatingType::TEAM_AGE,
                RatingType::TEAM_BASE,
                RatingType::TEAM_PLAYER,
                RatingType::TEAM_POWER,
                RatingType::TEAM_PRICE_BASE,
                RatingType::TEAM_PRICE_STADIUM,
                RatingType::TEAM_PRICE_TOTAL,
                RatingType::TEAM_STADIUM,
                RatingType::TEAM_VISITOR,
            ])) {
                $position = 1;
                $teamArray = Team::find()
                    ->where(['!=', 'team_id', 0])
                    ->orderBy(new Expression($order . ', `team_id` ASC'))
                    ->each();
                foreach ($teamArray as $team) {
                    /**
                     * @var Team $team
                     */
                    RatingTeam::updateAll([$place => $position], ['rating_team_team_id' => $team->team_id]);
                    $position++;
                }

                $place = $place . '_country';
                $countryArray = Country::find()
                    ->joinWith(['city.stadium.team'])
                    ->where(['!=', 'team_id', 0])
                    ->groupBy(['country_id'])
                    ->orderBy(['country_id' => SORT_ASC])
                    ->each();
                foreach ($countryArray as $country) {
                    /**
                     * @var Country $country
                     */
                    $position = 1;
                    $teamArray = Team::find()
                        ->joinWith(['stadium.city'])
                        ->where(['city_country_id' => $country->country_id])
                        ->orderBy(new Expression($order . ', `team_id`'))
                        ->each();
                    foreach ($teamArray as $team) {
                        /**
                         * @var Team $team
                         */
                        RatingTeam::updateAll([$place => $position], ['rating_team_team_id' => $team->team_id]);
                        $position++;
                    }
                }
            } elseif (RatingType::USER_RATING == $ratingType->rating_type_id) {
                $position = 1;
                $userArray = User::find()
                    ->joinWith(['team'])
                    ->where(['not', ['team_id' => null]])
                    ->andWhere(['!=', 'user_id', 0])
                    ->groupBy(['user_id'])
                    ->orderBy(new Expression($order . ', `user_id` ASC'))
                    ->each();
                foreach ($userArray as $user) {
                    /**
                     * @var User $user
                     */
                    RatingUser::updateAll([$place => $position], ['rating_user_user_id' => $user->user_id]);
                    $position++;
                }

                $place = $place . '_country';
                $countryArray = Country::find()
                    ->joinWith(['city.stadium.team'])
                    ->where(['!=', 'team_id', 0])
                    ->andWhere(['!=', 'team_user_id', 0])
                    ->groupBy(['country_id'])
                    ->orderBy(['country_id' => SORT_ASC])
                    ->each();
                foreach ($countryArray as $country) {
                    /**
                     * @var Country $country
                     */
                    $position = 1;
                    $userArray = User::find()
                        ->joinWith(['team.stadium.city'])
                        ->where(['!=', 'user_id', 0])
                        ->andWhere(['city_country_id' => $country->country_id])
                        ->groupBy(['user_id'])
                        ->orderBy(new Expression($order . ', `user_id` ASC'))
                        ->each();
                    foreach ($userArray as $user) {
                        /**
                         * @var User $user
                         */
                        RatingUser::updateAll([$place => $position], ['rating_user_user_id' => $user->user_id]);
                        $position++;
                    }
                }
            } elseif (in_array($ratingType->rating_type_id, [RatingType::COUNTRY_AUTO, RatingType::COUNTRY_STADIUM])) {
                $position = 1;
                $countryArray = Country::find()
                    ->joinWith(['city'])
                    ->where(['!=', 'city_id', 0])
                    ->groupBy(['country_id'])
                    ->orderBy(['country_id' => SORT_ASC])
                    ->each();
                foreach ($countryArray as $country) {
                    /**
                     * @var Country $country
                     */
                    RatingCountry::updateAll(
                        [$place => $position],
                        ['rating_country_country_id' => $country->country_id]
                    );
                    $position++;
                }
            } elseif (RatingType::COUNTRY_LEAGUE == $ratingType->rating_type_id) {
                $position = 1;
                $sql = "SELECT `country_id`
                        FROM `city`
                        LEFT JOIN `country`
                        ON `city_country_id`=`country_id`
                        LEFT JOIN 
                        (
                            SELECT SUM(`league_coefficient_point`)/COUNT(`league_coefficient_team_id`) AS `league_coefficient_coeff_1`,
                                   `league_coefficient_country_id`
                            FROM `league_coefficient`
                            WHERE `league_coefficient_season_id`=$seasonId
                            GROUP BY `league_coefficient_country_id`
                        ) AS `t1`
                        ON `country_id`=`t1`.`league_coefficient_country_id`
                        LEFT JOIN 
                        (
                            SELECT SUM(`league_coefficient_point`)/COUNT(`league_coefficient_team_id`) AS `league_coefficient_coeff_2`,
                                   `league_coefficient_country_id`
                            FROM `league_coefficient`
                            WHERE `league_coefficient_season_id`=$seasonId-1
                            GROUP BY `league_coefficient_country_id`
                        ) AS `t2`
                        ON `country_id`=`t2`.`league_coefficient_country_id`
                        LEFT JOIN 
                        (
                            SELECT SUM(`league_coefficient_point`)/COUNT(`league_coefficient_team_id`) AS `league_coefficient_coeff_3`,
                                   `league_coefficient_country_id`
                            FROM `league_coefficient`
                            WHERE `league_coefficient_season_id`=$seasonId-2
                            GROUP BY `league_coefficient_country_id`
                        ) AS `t3`
                        ON `country_id`=`t3`.`league_coefficient_country_id`
                        LEFT JOIN 
                        (
                            SELECT SUM(`league_coefficient_point`)/COUNT(`league_coefficient_team_id`) AS `league_coefficient_coeff_4`,
                                   `league_coefficient_country_id`
                            FROM `league_coefficient`
                            WHERE `league_coefficient_season_id`=$seasonId-3
                            GROUP BY `league_coefficient_country_id`
                        ) AS `t4`
                        ON `country_id`=`t4`.`league_coefficient_country_id`
                        LEFT JOIN 
                        (
                            SELECT SUM(`league_coefficient_point`)/COUNT(`league_coefficient_team_id`) AS `league_coefficient_coeff_5`,
                                   `league_coefficient_country_id`
                            FROM `league_coefficient`
                            WHERE `league_coefficient_season_id`=$seasonId-4
                            GROUP BY `league_coefficient_country_id`
                        ) AS `t5`
                        ON `country_id`=`t5`.`league_coefficient_country_id`
                        WHERE `city_id`!=0
                        GROUP BY `country_id`
                        ORDER BY IFNULL(`league_coefficient_coeff_1`, 0)+IFNULL(`league_coefficient_coeff_2`, 0)+IFNULL(`league_coefficient_coeff_3`, 0)+IFNULL(`league_coefficient_coeff_4`, 0)+IFNULL(`league_coefficient_coeff_5`, 0) DESC, `country_id` ASC";
                $countryArray = Yii::$app->db->createCommand($sql)->queryAll();

                foreach ($countryArray as $country) {
                    RatingCountry::updateAll(
                        [$place => $position],
                        ['rating_country_country_id' => $country['country_id']]
                    );
                    $position++;
                }
            }
        }
    }
}
