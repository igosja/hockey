<?php

namespace frontend\controllers;

use common\components\Controller;
use common\models\Season;
use common\models\Team;
use Yii;

/**
 * Class BaseController
 * @package frontend\controllers
 *
 * @property Team $myTeam
 * @property Team[] $myTeamArray
 * @property integer $seasonId
 */
class BaseController extends Controller
{
    /**
     * @var Team $myTeam
     */
    public $myTeam = null;

    /**
     * @var Team[] $myTeamArray
     */
    public $myTeamArray = [];

    /**
     * @var integer $seasonId
     */
    public $seasonId;

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $season = Season::find()->select(['season_id'])->orderBy(['season_id' => SORT_DESC])->limit(1)->one();
        $this->seasonId = $season->season_id;

        if (!Yii::$app->user->isGuest) {
            $this->myTeamArray = Team::find()
                ->select(['team_id', 'team_name'])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->all();
            $this->myTeam = Team::find()
                ->select(['team_id'])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->limit(1)
                ->one();
        }

        return parent::beforeAction($action);
    }
}
