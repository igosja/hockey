<?php

namespace frontend\controllers;

use common\components\Controller;
use common\models\National;
use common\models\Season;
use common\models\Site;
use common\models\Team;
use common\models\User;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ErrorAction;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class AbstractController
 * @package frontend\controllers
 *
 * @property National $myNational
 * @property National $myNationalOrVice
 * @property National $myNationalVice
 * @property Team $myTeam
 * @property Team $myTeamOrVice
 * @property Team $myTeamVice
 * @property Team[] $myOwnTeamArray
 * @property Team[] $myTeamArray
 * @property int $seasonId
 * @property User $user
 */
abstract class AbstractController extends Controller
{
    /**
     * @var National $myNational
     */
    public $myNational = null;

    /**
     * @var National $myNationalOrVice
     */
    public $myNationalOrVice = null;

    /**
     * @var National $myNationalVice
     */
    public $myNationalVice = null;

    /**
     * @var Team $myTeam
     */
    public $myTeam = null;

    /**
     * @var Team $myTeamOrVice
     */
    public $myTeamOrVice = null;

    /**
     * @var Team $myTeamVice
     */
    public $myTeamVice = null;

    /**
     * @var Team[] $myOwnTeamArray
     */
    public $myOwnTeamArray = [];

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
     * @return bool|Response
     * @throws Exception
     * @throws ForbiddenHttpException
     * @throws BadRequestHttpException
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
            '185.74.253.156', //Server
        ];

        $userIp = Yii::$app->request->headers->get('x-real-ip');
        if (!$userIp) {
            $userIp = Yii::$app->request->userIP;
        }

        if (YII_DEBUG && !in_array($userIp, $allowedIp) && !($action instanceof ErrorAction)) {
            throw new ForbiddenHttpException(
                'Этот сайт предназначен для разработки. Пользовательский сайт находиться по адресу https://virtual-hockey.org'
            );
        }

        $this->seasonId = Season::getCurrentSeason();

        if (!Yii::$app->user->isGuest) {
            $this->myTeamArray = ArrayHelper::merge(
                Team::find()
                    ->indexBy(['team_id'])
                    ->where(['team_user_id' => Yii::$app->user->id])
                    ->all(),
                Team::find()
                    ->indexBy(['team_id'])
                    ->where(['team_vice_id' => Yii::$app->user->id])
                    ->all()
            );

            $this->myOwnTeamArray = Team::find()
                ->indexBy(['team_id'])
                ->where(['team_user_id' => Yii::$app->user->id])
                ->all();

            $this->checkSessionMyTeamId();
            $this->myTeam = Team::find()
                ->where(['team_user_id' => Yii::$app->user->id])
                ->andFilterWhere(['team_id' => Yii::$app->session->get('myTeamId')])
                ->limit(1)
                ->one();

            $this->checkSessionMyTeamId();
            $this->myTeamVice = Team::find()
                ->where(['team_vice_id' => Yii::$app->user->id])
                ->andFilterWhere(['team_id' => Yii::$app->session->get('myTeamId')])
                ->limit(1)
                ->one();

            $this->myTeamOrVice = $this->myTeam ?: $this->myTeamVice;

            $this->myNational = National::find()
                ->where(['national_user_id' => Yii::$app->user->id])
                ->limit(1)
                ->one();

            $this->myNationalVice = National::find()
                ->where(['national_vice_id' => Yii::$app->user->id])
                ->limit(1)
                ->one();

            $this->myNationalOrVice = $this->myNational ?: $this->myNationalVice;

            $this->user = Yii::$app->user->identity;
            $this->user->user_date_login = time();
            if ($userIp && (User::ADMIN_USER_ID == $this->user->user_id || !in_array($userIp, $allowedIp))) {
                $this->user->user_ip = $userIp;
            }
            $this->user->save(true, ['user_date_login', 'user_ip']);

            if ($this->user->user_date_block > time() && !($action instanceof ErrorAction) && !($action->controller instanceof SupportController) && !($action->controller instanceof SiteController)) {
                throw new ForbiddenHttpException(
                    'Вам заблокирован доступ к сайту.
                    Причина блокировки - ' . $this->user->reasonBlock->block_reason_text
                );
            }

            if (!$this->user->user_date_confirm) {
                Yii::$app->session->setFlash('warning', 'Пожалуйста, подтвердите свой почтовый адрес');
            }

            if (!('restore' == $action->id && 'user' == $action->controller->id) && $this->user->user_date_delete) {
                return $this->redirect(['user/restore']);
            }
        }

        if (!Site::status() && !('site' == $action->controller->id && 'closed' == $action->id)) {
            return $this->redirect(['site/closed']);
        }

        if (Site::status() && 'site' == $action->controller->id && 'closed' == $action->id) {
            return $this->redirect(['site/index']);
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
