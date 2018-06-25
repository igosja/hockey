<?php

namespace frontend\controllers;

use common\models\ForumTheme;
use common\models\LoginForm;
use common\models\News;
use common\models\Review;
use common\models\User;
use frontend\models\ContactForm;
use frontend\models\SignUp;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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

        $this->view->title = 'Virtual Hockey Online League';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Virtual Hockey Online League - the best free hockey online manager'
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
     * @return string|\yii\web\Response
     */
    public function actionLogin(): string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
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
