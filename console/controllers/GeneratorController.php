<?php

namespace console\controllers;

use common\components\ErrorHelper;
use console\models\generator\CheckCronDate;
use console\models\generator\CheckLineup;
use console\models\generator\CheckTeamMoodLimit;
use console\models\generator\CountryAuto;
use console\models\generator\CountVisitor;
use console\models\generator\FillLineup;
use console\models\generator\FinanceStadium;
use console\models\generator\GameResult;
use console\models\generator\LineupToStatistic;
use console\models\generator\NationalVs;
use console\models\generator\PlayerPowerNewToOld;
use console\models\generator\SetAuto;
use console\models\generator\SetDefaultStyle;
use console\models\generator\SetStadium;
use console\models\generator\SetTicketPrice;
use console\models\generator\SetUserAuto;
use console\models\generator\SiteClose;
use console\models\generator\SiteOpen;
use console\models\generator\TeamToStatistic;
use console\models\generator\TeamVisitorAfterGame;
use console\models\generator\UpdateCronDate;
use console\models\generator\UpdateLeagueCoefficient;
use console\models\generator\UpdatePlayerStatistic;
use console\models\generator\UpdateTeamStatistic;
use console\models\generator\UpdateTeamVisitor;
use console\models\generator\UpdateUserRating;
use console\models\generator\UserToRating;
use Exception;

/**
 * Class GeneratorController
 * @package console\controllers
 */
class GeneratorController extends BaseController
{
    /**
     * @return void
     */
    public function actionIndex()
    {
        try {
            (new CheckCronDate)->execute();
            (new UpdateCronDate())->execute();
            (new SiteClose())->execute();
            (new PlayerPowerNewToOld())->execute();
            (new CheckTeamMoodLimit())->execute();
            (new CheckLineup())->execute();
            (new FillLineup())->execute();
            (new SetAuto())->execute();
            (new SetDefaultStyle())->execute();
            (new SetUserAuto())->execute();
            (new SetTicketPrice())->execute();
            (new CountVisitor())->execute();
            (new SetStadium())->execute();
            (new FinanceStadium())->execute();
            (new TeamToStatistic())->execute();
            (new UserToRating())->execute();
            (new LineupToStatistic())->execute();
            (new NationalVs())->execute();
            (new GameResult())->execute();
            (new UpdateLeagueCoefficient())->execute();
            (new UpdateTeamStatistic())->execute();
            (new UpdatePlayerStatistic())->execute();
            (new UpdateUserRating())->execute();
            (new CountryAuto())->execute();
            (new TeamVisitorAfterGame())->execute();
            (new UpdateTeamVisitor())->execute();
            (new SiteOpen())->execute();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }
}
