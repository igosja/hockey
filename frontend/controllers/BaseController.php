<?php

namespace frontend\controllers;

use common\components\Controller;
use common\components\ErrorHelper;
use common\models\Season;
use Exception;

/**
 * Class BaseController
 * @package frontend\controllers
 *
 * @property integer $seasonId
 */
class BaseController extends Controller
{
    public $seasonId;

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        $season = Season::find()->select(['season_id'])->orderBy(['season_id' => SORT_DESC])->limit(1)->one();
        $this->seasonId = $season->season_id;

        try {
            return parent::beforeAction($action);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return true;
    }
}
