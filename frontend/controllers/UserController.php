<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\components\TimeZoneHelper;
use common\models\Achievement;
use common\models\Blacklist;
use common\models\City;
use common\models\Country;
use common\models\Finance;
use common\models\History;
use common\models\Loan;
use common\models\Logo;
use common\models\National;
use common\models\Season;
use common\models\Sex;
use common\models\Team;
use common\models\Transfer;
use common\models\User;
use common\models\UserRating;
use Exception;
use frontend\models\ChangePassword;
use frontend\models\UserLogo;
use frontend\models\UserTransferFinance;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'drop-team',
                    'questionnaire',
                    'holiday',
                    'password',
                    'money-transfer',
                    'referral',
                    'delete',
                    'notes',
                    'black-list',
                    'logo',
                    'social',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'drop-team',
                            'questionnaire',
                            'holiday',
                            'password',
                            'money-transfer',
                            'delete',
                            'referral',
                            'notes',
                            'black-list',
                            'logo',
                            'social',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Exception
     */
    public function actionView($id = 0)
    {
        if (!$id) {
            if (!Yii::$app->user->isGuest) {
                $id = Yii::$app->user->id;
            } else {
                $id = User::ADMIN_USER_ID;
            }

            return $this->redirect(['user/view', 'id' => $id]);
        }

        $query = Country::find()
            ->where(['country_president_id' => $id])
            ->orWhere(['country_president_vice_id' => $id])
            ->orderBy(['country_name' => SORT_ASC]);
        $countryDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = Team::find()
            ->where(['or', ['team_user_id' => $id], ['team_vice_id' => $id]]);
        $teamDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = National::find()
            ->where(['or', ['national_user_id' => $id], ['national_vice_id' => $id]]);
        $nationalDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $userRating = UserRating::find()
            ->where(['user_rating_user_id' => $id, 'user_rating_season_id' => 0])
            ->one();
        if (!$userRating) {
            $userRating = new UserRating();
            $userRating->user_rating_user_id = $id;
            $userRating->save();
        }

        $query = UserRating::find()
            ->where(['user_rating_user_id' => $id])
            ->andWhere(['!=', 'user_rating_season_id', 0])
            ->orderBy(['user_rating_season_id' => SORT_DESC]);
        $ratingDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = History::find()
            ->where(['history_user_id' => $id])
            ->orderBy(['history_id' => SORT_DESC]);
        $historyDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('Профиль менеджера');

        return $this->render('view', [
            'countryDataProvider' => $countryDataProvider,
            'historyDataProvider' => $historyDataProvider,
            'nationalDataProvider' => $nationalDataProvider,
            'ratingDataProvider' => $ratingDataProvider,
            'teamDataProvider' => $teamDataProvider,
            'userRating' => $userRating,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAchievement($id)
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Achievement::find()
                ->where(['achievement_user_id' => $id])
                ->orderBy(['achievement_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Достижения менеджера');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionTrophy($id)
    {
        $query = Achievement::find()
            ->where(['achievement_user_id' => $id, 'achievement_place' => [0, 1], 'achievement_stage_id' => 0])
            ->orderBy(['achievement_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Трофеи менеджера');

        return $this->render('trophy', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionFinance($id)
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Finance::find()
                ->where(['finance_user_id' => $id])
                ->andWhere(['finance_season_id' => $seasonId])
                ->orderBy(['finance_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Финансы менеджера');

        return $this->render('finance', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionDeal($id)
    {
        $dataProviderTransferFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => Transfer::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['transfer_user_seller_id' => $id])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->orderBy(['transfer_ready' => SORT_DESC]),
        ]);
        $dataProviderTransferTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => Transfer::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['transfer_user_buyer_id' => $id])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->orderBy(['transfer_ready' => SORT_DESC]),
        ]);
        $dataProviderLoanFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => Loan::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['loan_user_seller_id' => $id])
                ->andWhere(['!=', 'loan_ready', 0])
                ->orderBy(['loan_ready' => SORT_DESC]),
        ]);
        $dataProviderLoanTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => Loan::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['loan_user_buyer_id' => $id])
                ->andWhere(['!=', 'loan_ready', 0])
                ->orderBy(['loan_ready' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Сделки менеджера');

        return $this->render('deal', [
            'dataProviderTransferFrom' => $dataProviderTransferFrom,
            'dataProviderTransferTo' => $dataProviderTransferTo,
            'dataProviderLoanFrom' => $dataProviderLoanFrom,
            'dataProviderLoanTo' => $dataProviderLoanTo,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionQuestionnaire()
    {
        /**
         * @var User $model
         */
        $model = Yii::$app->user->identity;
        Yii::$app->request->setQueryParams(['id' => $model->user_id]);

        if ($model->updateQuestionnaire()) {
            $this->setSuccessFlash('Данные успешно сохранены.');
            return $this->refresh();
        }

        $dayArray = [];
        for ($i = 1; $i <= 31; $i++) {
            $dayArray[$i] = $i;
        }

        $monthArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthArray[$i] = $i;
        }

        $currentYear = date('Y');
        $firstYear = $currentYear - 100;
        $yearArray = [];
        for ($i = $currentYear; $i >= $firstYear; $i--) {
            $yearArray[$i] = $i;
        }

        $this->setSeoTitle('Анкета менеджера');

        return $this->render('questionnaire', [
            'countryArray' => Country::selectOptions(),
            'dayArray' => $dayArray,
            'model' => $model,
            'monthArray' => $monthArray,
            'sexArray' => Sex::selectOptions(),
            'timeZoneArray' => TimeZoneHelper::zoneList(),
            'yearArray' => $yearArray,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionHoliday()
    {
        /**
         * @var User $model
         */
        $model = Yii::$app->user->identity;
        Yii::$app->request->setQueryParams(['id' => $model->user_id]);

        if ($model->updateHoliday()) {
            $this->setSuccessFlash('Данные успешно сохранены.');
            return $this->refresh();
        }

        $teamArray = [];
        foreach ($this->myTeamArray as $myTeam) {
            $userArray = User::find()
                ->where(['>', 'user_date_login', time() - 604800])
                ->andWhere(['!=', 'user_id', $this->user->user_id])
                ->andWhere(['user_no_vice' => 0])
                ->andWhere([
                    'not',
                    [
                        'user_id' => Team::find()
                            ->joinWith(['stadium.city.country'])
                            ->select(['team_user_id'])
                            ->where(['country_id' => $myTeam->stadium->city->country->country_id])
                    ]
                ])
                ->andWhere([
                    'not',
                    [
                        'user_id' => Team::find()
                            ->joinWith(['stadium.city.country'])
                            ->select(['team_vice_id'])
                            ->where(['country_id' => $myTeam->stadium->city->country->country_id])
                            ->andWhere(['!=', 'team_id', $myTeam->team_id])
                    ]
                ])
                ->orderBy(['user_login' => SORT_ASC])
                ->all();
            $teamArray[] = [
                'team' => $myTeam,
                'userArray' => ArrayHelper::map($userArray, 'user_id', 'user_login'),
            ];
        }

        $this->setSeoTitle('Отпуск менеджера');

        return $this->render('holiday', [
            'model' => $model,
            'teamArray' => $teamArray,
        ]);
    }

    /**
     * @return array|string|Response
     * @throws Exception
     */
    public function actionPassword()
    {
        $model = new ChangePassword();
        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->change()) {
            $this->setSuccessFlash('Пароль успешно изменён.');
            return $this->refresh();
        }

        $this->setSeoTitle('Смена пароля');

        return $this->render('password', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionMoneyTransfer()
    {
        $model = new UserTransferFinance(['user' => Yii::$app->user->identity]);
        if ($model->execute()) {
            $this->setSuccessFlash('Деньги успешно переведены');
            return $this->refresh();
        }

        $countryArray = Country::find()
            ->where(['!=', 'country_id', 0])
            ->andWhere(['country_id' => City::find()->select(['city_country_id'])])
            ->orderBy(['country_name' => SORT_ASC])
            ->all();

        $teamArray = Team::find()
            ->where(['!=', 'team_id', 0])
            ->orderBy(['team_name' => SORT_ASC])
            ->all();
        $teamItems = [];

        foreach ($teamArray as $team) {
            $teamItems[$team->team_id] = $team->fullName();
        }

        $this->setSeoTitle('Перевод денег с личного счета');

        return $this->render('money-transfer', [
            'countryArray' => ArrayHelper::map($countryArray, 'country_id', 'country_name'),
            'model' => $model,
            'teamArray' => $teamItems,
        ]);
    }

    /**
     * @return string
     */
    public function actionReferral()
    {
        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);
        $query = User::find()
            ->where(['user_referrer_id' => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Партнёрская программа');

        return $this->render('referral', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionDropTeam()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        if (Yii::$app->request->get('ok')) {
            try {
                $this->myTeam->managerFire();
                $this->setSuccessFlash();
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }

            return $this->redirect(['user/drop-team']);
        }

        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);

        $this->setSeoTitle('Отказ от команды');

        return $this->render('drop-team', [
            'team' => $this->myTeam,
        ]);
    }

    /**
     * @return string
     */
    public function actionReRegister()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        if (Yii::$app->request->get('ok')) {
            try {
                $result = $this->myTeam->reRegister();
                if ($result['status']) {
                    $this->setSuccessFlash($result['message']);
                } else {
                    $this->setErrorFlash($result['message']);
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }

            return $this->redirect(['user/re-register']);
        }

        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);

        $this->setSeoTitle('Преререгистрация команды');

        return $this->render('re-register', [
            'team' => $this->myTeam,
        ]);
    }

    /**
     * @return string
     */
    public function actionDelete()
    {
        if (Yii::$app->request->get('ok')) {
            try {
                $this->user->user_date_delete = time();
                $this->user->save(true, ['user_date_delete']);

                foreach ($this->myTeamArray as $team) {
                    $team->managerFire();
                }

                $this->setSuccessFlash();
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }

            return $this->redirect(['user/delete']);
        }

        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);

        $this->setSeoTitle('Удаление аккаунта');
        return $this->render('delete');
    }

    /**
     * @return string
     */
    public function actionRestore()
    {
        if (Yii::$app->request->get('ok')) {
            try {
                $this->user->user_date_delete = 0;
                $this->user->save(true, ['user_date_delete']);

                $this->setSuccessFlash();
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }

            return $this->redirect(['user/view', 'id' => $this->user->user_id]);
        }

        Yii::$app->request->setQueryParams(['id' => Yii::$app->user->id]);

        $this->setSeoTitle('Восстановление аккаунта');
        return $this->render('restore');
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionNotes()
    {
        $model = $this->user;
        Yii::$app->request->setQueryParams(['id' => $model->user_id]);

        if ($model->updateNotes()) {
            $this->setSuccessFlash('Данные успешно сохранены.');
            return $this->refresh();
        }

        $this->setSeoTitle('Блокнот менеджера');

        return $this->render('notes', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionBlacklist($id)
    {
        $blacklist = Blacklist::find()
            ->where([
                'blacklist_owner_user_id' => $this->user->user_id,
                'blacklist_interlocutor_user_id' => $id,
            ])
            ->limit(1)
            ->one();
        if ($blacklist) {
            $blacklist->delete();
        } else {
            $model = new Blacklist();
            $model->blacklist_owner_user_id = $this->user->user_id;
            $model->blacklist_interlocutor_user_id = $id;
            $model->save();
        }

        return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer : ['user/view', 'id' => $id]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionLogo()
    {
        $user = $this->user;
        Yii::$app->request->setQueryParams(['id' => $user->user_id]);

        $model = new UserLogo(['userId' => $user->user_id]);
        if ($model->upload()) {
            $this->setSuccessFlash();
            return $this->refresh();
        }

        $logoArray = Logo::find()
            ->where(['logo_team_id' => 0])
            ->all();

        $this->setSeoTitle($user->user_login . '. Загрузка фото');

        return $this->render('logo', [
            'logoArray' => $logoArray,
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionSocial()
    {
        $model = $this->user;
        Yii::$app->request->setQueryParams(['id' => $model->user_id]);

        if ($model->updateSocial()) {
            $this->setSuccessFlash('Данные успешно сохранены.');
            return $this->refresh();
        }

        $this->setSeoTitle($model->user_login . '. Профили в социальных сетях.');

        return $this->render('social', [
            'model' => $model,
        ]);
    }
}
