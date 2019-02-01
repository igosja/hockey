<?php

namespace console\models\generator;

use common\components\ErrorHelper;
use common\models\Schedule;
use console\controllers\AbstractController;
use console\models\newSeason\BaseMaintenance;
use console\models\newSeason\ChampionshipRotate;
use console\models\newSeason\CountryAutoReset;
use console\models\newSeason\EndBuildingBase;
use console\models\newSeason\EndBuildingStadium;
use console\models\newSeason\EndSchool;
use console\models\newSeason\EndScout;
use console\models\newSeason\EndTraining;
use console\models\newSeason\FireNational;
use console\models\newSeason\GameRow;
use console\models\newSeason\Injury;
use console\models\newSeason\InsertChampionship;
use console\models\newSeason\InsertConference;
use console\models\newSeason\InsertLeague;
use console\models\newSeason\InsertOffSeason;
use console\models\newSeason\InsertSchedule;
use console\models\newSeason\InsertWorldCup;
use console\models\newSeason\NoDeal;
use console\models\newSeason\OlderPlayer;
use console\models\newSeason\Pension;
use console\models\newSeason\PensionInform;
use console\models\newSeason\PlayerFromNational;
use console\models\newSeason\PlayerPowerChange;
use console\models\newSeason\PlayerTireBaseLevel;
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
            new InsertSchedule(),
            new ChampionshipRotate(),
            new InsertOffSeason(),
            new InsertConference(),
            new InsertChampionship(),
            new InsertLeague(),
            new InsertWorldCup(),
            new EndBuildingBase(),
            new EndBuildingStadium(),
            new RandPhysical(),
            new PlayerTireBaseLevel(),
            new EndTraining(),
            new EndSchool(),
            new EndScout(),
            new PlayerPowerChange(),
            new Injury(),
            new Pension(),
            new OlderPlayer(),
            new PensionInform(),
            new BaseMaintenance(),
            new MoodReset(),
            new GameRow(),
            new CountryAutoReset(),
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
