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

        $this->view->title = Yii::t('frontend-controllers-site-index', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-site-index', 'seo-description')
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

        $this->view->title = Yii::t('frontend-controllers-site-login', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-site-login', 'seo-description')
        ]);

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
                    Yii::$app->session->setFlash('success', Yii::t('frontend-controllers-site-sign-up', 'success'));
                    return $this->redirect(['site/activation']);
                }
                Yii::$app->session->setFlash('error', Yii::t('frontend-controllers-site-sign-up', 'error'));
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('error', Yii::t('frontend-controllers-site-sign-up', 'error'));
            }
        }

        $this->view->title = Yii::t('frontend-controllers-site-sign-up', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-site-sign-up', 'seo-description')
        ]);

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

        if ($model->load(Yii::$app->request->post()) || $model->load(Yii::$app->request->get(), '')) {
            try {
                if ($model->activate()) {
                    Yii::$app->session->setFlash('success', Yii::t('frontend-controllers-site-activation', 'success'));
                }
            } catch (Exception $e) {
                ErrorHelper::log($e);
                Yii::$app->session->setFlash('success', Yii::t('frontend-controllers-site-activation', 'error'));
            }
            return $this->redirect(['site/activation']);
        }

        $this->view->title = Yii::t('frontend-controllers-site-activation', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-site-activation', 'seo-description')
        ]);

        return $this->render('activation', [
            'model' => $model,
        ]);
    }
}
