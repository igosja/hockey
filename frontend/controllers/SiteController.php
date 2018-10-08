<?php

namespace frontend\controllers;

use common\models\ForumTheme;
use common\models\LoginForm;
use common\models\News;
use common\models\Review;
use common\models\User;
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
                'only' => ['logout', 'sign-up'],
                'rules' => [
                    [
                        'actions' => ['sign-up'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

        $this->view->title = Yii::t('frontend-controllers-Site', 'index-seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-Site', 'index-seo-description')
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

        $this->view->title = Yii::t('frontend-controllers-Site', 'login-seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-Site', 'login-seo-description')
        ]);

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return array|string|Response
     * @throws \yii\db\Exception
     */
    public function actionSignUp()
    {
        $model = new SignUp();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signUp()) {
                return $this->redirect(['activation']);
            }
        }

        $this->view->title = 'Sign up';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Sign up - Virtual Hockey Online League'
        ]);

        return $this->render('signUp', [
            'model' => $model,
        ]);
    }
}
