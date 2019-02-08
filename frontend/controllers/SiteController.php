<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Cookie;
use common\models\Event;
use common\models\EventType;
use common\models\ForumMessage;
use common\models\Game;
use common\models\LoginForm;
use common\models\News;
use common\models\Review;
use common\models\User;
use Exception;
use frontend\models\Activation;
use frontend\models\ActivationRepeat;
use frontend\models\Password;
use frontend\models\PasswordRestore;
use frontend\models\SignUp;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $gameArray = Game::find()
            ->where(['!=', 'game_played', 0])
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $lineupArray = [];
            foreach ($game->lineup as $lineup) {
                $lineupArray[$lineup->lineup_player_id] = [
                    'lineup_id' => $lineup->lineup_id,
                    'lineup_team_id' => $lineup->lineup_team_id,
                    'lineup_position_id' => $lineup->lineup_position_id,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'game_with_shootout' => 0,
                    'loose' => 0,
                    'pass' => 0,
                    'point' => 0,
                    'save' => 0,
                    'shot_gk' => 0,
                    'shutout' => 0,
                    'win' => 0,
                    'shootout_win' => 0,
                    'face_off' => 0,
                    'face_off_win' => 0,
                    'plus_minus' => $lineup->lineup_plus_minus,
                    'score' => 0,
                    'score_draw' => 0,
                    'score_power' => 0,
                    'score_short' => 0,
                    'score_win' => 0,
                    'score_shot' => 0,
                ];
            }

            $eventArray = Event::find()
                ->where(['event_game_id' => $game->game_id])
                ->orderBy(['event_id' => SORT_ASC])
                ->all();
            foreach ($eventArray as $event) {
                if (EventType::GOAL == $event->event_event_type_id) {
                    if ($event->event_player_assist_1_id == $event->event_player_score_id) {
                        $event->event_player_assist_1_id = 0;
                        $event->event_player_assist_2_id = 0;
                        $event->save(true, ['event_player_assist_1_id', 'event_player_assist_2_id']);
                    } elseif (in_array($event->event_player_assist_2_id, [$event->event_player_score_id, $event->event_player_assist_1_id])) {
                        $event->event_player_assist_2_id = 0;
                        $event->save(true, ['event_player_assist_2_id']);
                    }
                }
            }

            print '<pre>';
            print_r($eventArray);
            exit;
        }
        exit;
        if (Yii::$app->request->get('ref')) {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'user_referrer_id',
                'value' => Yii::$app->request->get('ref'),
            ]));
        }

        $birthdays = User::find()
            ->where(['user_birth_day' => date('d'), 'user_birth_month' => date('Y')])
            ->orderBy(['user_id' => SORT_ASC])
            ->all();
        $countryNews = News::find()
            ->where(['!=', 'news_country_id', 0])
            ->orderBy(['news_id' => SORT_DESC])
            ->limit(10)
            ->one();
        $forumMessage = ForumMessage::find()
            ->select([
                '*',
                'forum_message_id' => 'MAX(forum_message_id)',
                'forum_message_date' => 'MAX(forum_message_date)',
            ])
            ->joinWith(['forumTheme.forumGroup'])
            ->where([
                'forum_group.forum_group_country_id' => 0
            ])
            ->groupBy(['forum_message_forum_theme_id'])
            ->orderBy(['forum_message_id' => SORT_DESC])
            ->limit(10)
            ->all();
        $news = News::find()->where(['news_country_id' => 0])->orderBy(['news_id' => SORT_DESC])->one();
        $reviews = Review::find()->orderBy(['review_id' => SORT_DESC])->limit(10)->all();

        $this->view->title = 'Хоккейный онлайн-менеджер';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Виртуальная Хоккейная Лига - лучший бесплатный хоккейный онлайн-менеджер.',
        ]);

        return $this->render('index', [
            'birthdays' => $birthdays,
            'countryNews' => $countryNews,
            'forumMessage' => $forumMessage,
            'news' => $news,
            'reviews' => $reviews,
        ]);
    }

    /**
     * @param string $code
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAuth($code)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $user = User::find()
            ->where(['user_code' => $code])
            ->limit(1)
            ->one();
        $this->notFound($user);

        Yii::$app->user->login($user, 2592000);
        return $this->redirect(['team/view']);
    }

    /**
     * @return array|string|Response
     * @throws Exception
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['team/view']);
        }

        $model = new LoginForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $cookies = Yii::$app->request->cookies;
            /**
             * @var User $user
             */
            $user = Yii::$app->user->identity;
            if ($cookies->getValue('computer_code')) {
                $child = User::find()
                    ->where(['!=', 'user_id', Yii::$app->user->id])
                    ->andWhere(['user_code' => $cookies->getValue('computer_code')])
                    ->limit(1)
                    ->one();
                if ($child) {
                    $cookie = Cookie::find()
                        ->where([
                            'or',
                            ['cookie_user_1_id' => Yii::$app->user->id, 'cookie_user_2_id' => $child->user_id],
                            ['cookie_user_2_id' => Yii::$app->user->id, 'cookie_user_1_id' => $child->user_id],
                        ])
                        ->limit(1)
                        ->one();
                    if (!$cookie) {
                        $cookie = new Cookie();
                        $cookie->cookie_user_1_id = Yii::$app->user->id;
                        $cookie->cookie_user_2_id = $child->user_id;
                        $cookie->save();
                    }
                    $cookie->cookie_date = time();
                    $cookie->cookie_count = $cookie->cookie_count + 1;
                    $cookie->save(true, ['cookie_date', 'cookie_count']);
                }
            }

            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'computer_code',
                'value' => $user->user_code,
            ]));

            return $this->redirect(['team/view']);
        } else {
            $model->password = '';
        }

        $this->setSeoTitle('Вход');

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return array|string|Response
     */
    public function actionSignUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['team/view']);
        }

        $model = new SignUp();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->signUp()) {
                    Yii::$app->session->setFlash(
                        'success',
                        'Регистрация прошла успешно. Осталось подтвердить ваш email.'
                    );
                    return $this->redirect(['site/activation']);
                }
                Yii::$app->session->setFlash('error', 'Не удалось провести регистрацию');
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', 'Не удалось провести регистрацию');
            }
        }

        $this->setSeoTitle('Регистрация');

        return $this->render('sign-up', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|string
     */
    public function actionActivation()
    {
        $model = new Activation();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (($model->load(Yii::$app->request->post()) || $model->load(Yii::$app->request->get(), '')) && $model->code) {
            try {
                if ($model->activate()) {
                    $this->setSuccessFlash('Активация прошла успешно');
                    return $this->redirect(['site/activation']);
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }
            $this->setErrorFlash('Не удалось провести активацию');
        }

        $this->setSeoTitle('Активация аккаунта');

        return $this->render('activation', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|string
     */
    public function actionActivationRepeat()
    {
        $model = new ActivationRepeat();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->send()) {
                    $this->setSuccessFlash('Код активации успешно отправлен');
                    return $this->redirect(['site/activation']);
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }
            $this->setErrorFlash('Не удалось отправить код активации');
        }

        $this->setSeoTitle('Активация аккаунта');

        return $this->render('activation-repeat', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|string|Response
     */
    public function actionPassword()
    {
        $model = new Password();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->send()) {
                    Yii::$app->session->setFlash(
                        'success',
                        'Письмо с инструкциями по восстановлению пароля успешно отправлено на email'
                    );
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось восстановить пароль');
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', 'Не удалось восстановить пароль');
            }
        }

        $this->setSeoTitle('Восстановление пароля');

        return $this->render('password', [
            'model' => $model,
        ]);
    }

    /**
     * @return array|string|Response
     */
    public function actionPasswordRestore()
    {
        $model = new PasswordRestore();
        $model->setAttributes(Yii::$app->request->get());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->restore()) {
                    Yii::$app->session->setFlash('success', 'Пароль успешно изменён');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось изменить пароль');
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', 'Не удалось изменить пароль');
            }
        }

        $this->setSeoTitle('Восстановление пароля');

        return $this->render('password-restore', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAuthByKey()
    {
        /**
         * @var User $user
         */
        $user = User::find()
            ->where(['user_code' => Yii::$app->request->get('code')])
            ->limit(1)
            ->one();
        $this->notFound($user);

        Yii::$app->user->login($user);

        return $this->redirect(['site/index']);
    }
}
