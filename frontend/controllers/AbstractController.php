<?php

namespace frontend\controllers;

use common\components\Controller;
use common\models\Season;
use common\models\Site;
use common\models\Team;
use common\models\User;
use Yii;
use yii\web\ErrorAction;
use yii\web\ForbiddenHttpException;

/**
 * Class AbstractController
 * @package frontend\controllers
 *
 * @property Team $myTeam
 * @property Team[] $myTeamArray
 * @property int $seasonId
 * @property User $user
 */
abstract class AbstractController extends Controller
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
     * @var User $user
     */
    public $user = null;

    /**
     * @param $action
     * @return bool
     * @throws \Exception
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ('ru' != Yii::$app->language) {
            Yii::$app->language = 'ru';
        }

        $allowedIp = [
            '62.205.148.101',//Peremohy-60
            '185.38.209.242',//Zhabaeva-7
            '31.172.137.26',//Zhabaeva-7
            '127.0.0.1',
        ];

        if (YII_DEBUG && !in_array(Yii::$app->request->userIP, $allowedIp) && !($action instanceof ErrorAction)) {
            throw new ForbiddenHttpException(
                'Этот сайт предназначен для разработки. Пользовательский сайт находиться по адресу https://virtual-hockey.org'
            );
        }

        if (!Site::status() && !($action instanceof ErrorAction)) {
            throw new ForbiddenHttpException('На сайте проводятся технические работы. Зайдите, пожалуйста, позже.');
        }

        $this->seasonId = Season::getCurrentSeason();

        if (!Yii::$app->user->isGuest) {
            $this->myTeamArray = Team::find()
                ->indexBy(['team_id'])
                ->select(['team_id', 'team_name', 'team_stadium_id'])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->all();

            $this->checkSessionMyTeamId();
            $this->myTeam = Team::find()
                ->where(['team_user_id' => Yii::$app->user->id])
                ->andFilterWhere(['team_id' => Yii::$app->session->get('myTeamId')])
                ->limit(1)
                ->one();

            $this->user = Yii::$app->user->identity;
            $this->user->user_date_login = time();
            $this->user->save(true, ['user_date_login']);
        }

        return true;
    }

    /**
     * @return void
     */
    private function checkSessionMyTeamId()
    {
        if (Yii::$app->session->get('myTeamId')) {
            if (!in_array(Yii::$app->session->get('myTeamId'), array_keys($this->myTeamArray))) {
                Yii::$app->session->remove('myTeamId');
            }
        }
    }

    /**
     * @param $text
     * @return void
     */
    public function setSeoTitle($text)
    {
        $this->view->title = $text;
        $this->setSeoDescription();
    }

    /**
     * @return void
     */
    private function setSeoDescription()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->view->title . ' на сайте Виртуальной Хоккейной Лиги'
        ]);
    }

    /**
     * @throws ForbiddenHttpException
     */
    protected function forbiddenAuth()
    {
        throw new ForbiddenHttpException('Эта страница доступна только авторизированных мользователям');
    }

    /**
     * @throws ForbiddenHttpException
     */
    protected function forbiddenRole()
    {
        throw new ForbiddenHttpException('Не хватает прав для выполнения этой операции');
    }
}
