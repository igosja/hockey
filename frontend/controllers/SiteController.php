<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\ForumTheme;
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
class SiteController extends BaseController
{
    /**
     * @return array
     */
    public function behaviors(): array
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
    public function actions(): array
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
    public function actionIndex(): string
    {
        $birthdays = User::find()
            ->where(['user_birth_day' => date('d'), 'user_birth_month' => date('Y')])
            ->orderBy(['user_id' => SORT_ASC])
            ->all();
        $countryNews = News::find()
            ->where(['!=', 'news_country_id', null])
            ->orderBy(['news_id' => SORT_DESC])
            ->limit(10)
            ->one();
        $forumThemes = ForumTheme::find()->orderBy(['forum_theme_date_update' => SORT_DESC])->limit(10)->all();
        $news = News::find()->orderBy(['news_id' => SORT_DESC])->one();
        $reviews = Review::find()->orderBy(['review_id' => SORT_DESC])->limit(10)->all();

        $this->view->title = 'Хоккейный онлайн-менеджер';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Виртуальная Хоккейная Лига - лучший бесплатный хоккейный онлайн-менеджер.',
        ]);

        return $this->render('index', [
            'birthdays' => $birthdays,
            'countryNews' => $countryNews,
            'forumThemes' => $forumThemes,
            'news' => $news,
            'reviews' => $reviews,
        ]);
    }

    /**
     * @return array|string|Response
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
            return $this->redirect(['team/view']);
        } else {
            $model->password = '';
        }

        $this->view->title = 'Вход';
        $this->setSeoDescription();

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
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

        $this->view->title = 'Регистрация';
        $this->setSeoDescription();

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
                    Yii::$app->session->setFlash('success', 'Активация прошла успешно');
                    return $this->redirect(['site/activation']);
                }
                Yii::$app->session->setFlash('error', 'Не удалось провести активацию');
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', 'Не удалось провести активацию');
            }
        }

        $this->view->title = 'Активация аккаунта';
        $this->setSeoDescription();

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
                    Yii::$app->session->setFlash('success', 'Код активации успешно отправлен');
                    return $this->redirect(['site/activation']);
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось отправить код активации');
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', 'Не удалось отправить код активации');
            }
        }

        $this->view->title = 'Активация аккаунта';
        $this->setSeoDescription();

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

        $this->view->title = 'Восстановление пароля';
        $this->setSeoDescription();

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

        $this->view->title = 'Восстановление пароля';
        $this->setSeoDescription();

        return $this->render('password-restore', [
            'model' => $model,
        ]);
    }
}
