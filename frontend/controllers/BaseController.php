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
 * @property int $seasonId
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
     * @var int $seasonId
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
                ->indexBy(['team_id'])
                ->select(['team_id', 'team_name'])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->all();

            $this->checkSessionMyTeamId();
            $this->myTeam = Team::find()
                ->select([
                    'team_finance',
                    'team_id',
                    'team_name',
                    'team_stadium_id'
                ])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->andFilterWhere(['team_id' => Yii::$app->session->get('myTeamId')])
                ->limit(1)
                ->one();
        }

        return parent::beforeAction($action);
    }

    private function checkSessionMyTeamId()
    {
        if (Yii::$app->session->get('myTeamId')) {
            if (!in_array(Yii::$app->session->get('myTeamId'), array_keys($this->myTeamArray))) {
                Yii::$app->session->remove('myTeamId');
            }
        }
    }
}
