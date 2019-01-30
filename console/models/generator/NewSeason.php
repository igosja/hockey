<?php

namespace console\models\generator;

use common\components\ErrorHelper;
use common\models\Schedule;
use console\controllers\AbstractController;
use console\models\newSeason\CountryAuto as AutoReset;
use console\models\newSeason\FireNational;
use console\models\newSeason\Injury;
use console\models\newSeason\NoDeal;
use console\models\newSeason\PlayerFromNational;
use console\models\newSeason\PlayerGameRow as GameRow;
use console\models\newSeason\RandPhysical;
use Exception;
use Yii;

/**
 * Class NewSeason
 * @package console\models\generator
 */
class NewSeason
{
    /**
     * @return bool
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`-86400, \'%Y-%m-%d\')=CURDATE()')
            ->limit(1)
            ->one();
        if (!$schedule) {
            return true;
        }

        $modelArray = [
            'f_igosja_newseason_insert_season',
            new NoDeal(),
            new FireNational(),
            new PlayerFromNational(),
            'f_igosja_newseason_national_transfer_money',
            'f_igosja_newseason_league_participant',
            'f_igosja_newseason_league_coefficient',
            'f_igosja_newseason_league_limit',
            'f_igosja_newseason_schedule',
            'f_igosja_newseason_championship_rotate',
            'f_igosja_newseason_offseason',
            'f_igosja_newseason_conference',
            'f_igosja_newseason_championship',
            'f_igosja_newseason_league',
            'f_igosja_newseason_worldcup',
            'f_igosja_newseason_building_base',
            'f_igosja_newseason_building_stadium',
            new RandPhysical(),
            'f_igosja_newseason_tire_base_level',
            'f_igosja_newseason_training',
            'f_igosja_newseason_school',
            'f_igosja_newseason_scout',
            'f_igosja_newseason_player_power_change',
            new Injury(),
            'f_igosja_newseason_older_player',
            'f_igosja_newseason_pension',
            'f_igosja_newseason_pension_inform',
            'f_igosja_newseason_maintenance',
            new MoodReset(),
            new GameRow(),
            new AutoReset(),
            'f_igosja_newseason_truncate',
        ];

        try {
            /**
             * @var AbstractController $controller
             */
            $controller = Yii::$app->controller;
            $controller->progress($modelArray);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return true;
    }
}
