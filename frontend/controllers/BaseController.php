<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Season;
use Exception;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    /**
     * @param ActiveRecord|null $model
     * @throws NotFoundHttpException
     */
    protected function notFound(ActiveRecord $model = null)
    {
        if (!$model) {
            throw new NotFoundHttpException();
        }
    }
}
