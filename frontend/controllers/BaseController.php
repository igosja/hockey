<?php

namespace frontend\controllers;

use common\components\Controller;
use common\models\Season;
use common\models\Team;
use Yii;
use yii\web\ForbiddenHttpException;

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
        $this->seasonId = Season::getCurrentSeason();

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

    /**
     * @return void
     */
    private function checkSessionMyTeamId(): void
    {
        if (Yii::$app->session->get('myTeamId')) {
            if (!in_array(Yii::$app->session->get('myTeamId'), array_keys($this->myTeamArray))) {
                Yii::$app->session->remove('myTeamId');
            }
        }
    }

    /**
     * @return void
     */
    protected function setSeoDescription(): void
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->view->title . ' на сайте Виртуальной Хоккейной Лиги'
        ]);
    }

    /**
     * @throws ForbiddenHttpException
     */
    protected function forbiddenRole(): void
    {
        throw new ForbiddenHttpException('Не хватает прав для выполнения этой операции');
    }
}
