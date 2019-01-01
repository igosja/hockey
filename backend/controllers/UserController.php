<?php

namespace backend\controllers;

use backend\models\UserSearch;
use common\models\User;
use Yii;
use yii\web\Response;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Пользователи';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAuth(int $id): Response
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        Yii::$app->request->setBaseUrl('');
        return $this->redirect(['site/auth', 'code' => $model->user_code]);
    }
}
