<?php

namespace backend\controllers;

use backend\models\NewsSearch;
use common\components\ErrorHelper;
use common\models\News;
use Throwable;
use Yii;

/**
 * Class NewsController
 * @package backend\controllers
 */
class NewsController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Новости';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['view', 'id' => $model->news_id]);
        }

        $this->view->title = 'Создание новости';
        $this->view->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['news/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate(int $id)
    {
        $model = News::find()->where(['news_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['view', 'id' => $model->news_id]);
        }

        $this->view->title = 'Редактирование новости';
        $this->view->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['news/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->news_title,
            'url' => ['news/view', 'id' => $model->news_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = News::find()->where(['news_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->news_title;
        $this->view->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['news/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id)
    {
        $model = News::find()->where(['news_id' => $id])->limit(1)->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['news/index']);
    }
}
