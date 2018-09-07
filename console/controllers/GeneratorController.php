<?php

namespace console\controllers;

use common\components\ErrorHelper;
use console\models\generator\CheckCronDate;
use console\models\generator\CheckLineup;
use console\models\generator\CheckTeamMoodLimit;
use console\models\generator\FillLineup;
use console\models\generator\PlayerPowerNewToOld;
use console\models\generator\SetAuto;
use console\models\generator\SetDefaultStyle;
use console\models\generator\SetStadium;
use console\models\generator\SetTicketPrice;
use console\models\generator\SetUserAuto;
use console\models\generator\SiteClose;
use console\models\generator\SiteOpen;
use console\models\generator\UpdateCronDate;
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
            $this->checkCronDate();
            $this->updateCronDate();
            $this->siteClose();
            $this->playerPowerNewToOld();
            $this->checkTeamMoodLimit();
            $this->checkLineup();
            $this->fillLineup();
            $this->setAuto();
            $this->setDefaultStyle();
            $this->setUserAuto();
            $this->setTicketPrice();
            $this->setStadium();
            $this->siteOpen();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }

    /**
     * @throws \yii\base\ExitException
     */
    private function checkCronDate()
    {
        (new CheckCronDate)->execute();
    }

    /**
     * @return void
     */
    private function updateCronDate()
    {
        (new UpdateCronDate())->execute();
    }

    /**
     * @return void
     */
    private function siteClose()
    {
        (new SiteClose())->execute();
    }

    /**
     * @return void
     */
    private function playerPowerNewToOld()
    {
        (new PlayerPowerNewToOld())->execute();
    }

    /**
     * @return void
     */
    private function checkTeamMoodLimit()
    {
        (new CheckTeamMoodLimit())->execute();
    }

    /**
     * @throws \yii\db\Exception
     */
    private function checkLineup()
    {
        (new CheckLineup())->execute();
    }

    /**
     * @return void
     */
    private function fillLineup()
    {
        (new FillLineup())->execute();
    }

    /**
     * @return void
     */
    private function setAuto()
    {
        (new SetAuto())->execute();
    }

    /**
     * @return void
     */
    private function setDefaultStyle()
    {
        (new SetDefaultStyle())->execute();
    }

    /**
     * @return void
     */
    private function setUserAuto()
    {
        (new SetUserAuto())->execute();
    }

    /**
     * @return void
     */
    private function setTicketPrice()
    {
        (new SetTicketPrice())->execute();
    }

    /**
     * @throws \yii\db\Exception
     */
    private function setStadium()
    {
        (new SetStadium())->execute();
    }

    /**
     * @return void
     */
    private function siteOpen()
    {
        (new SiteOpen())->execute();
    }
}
