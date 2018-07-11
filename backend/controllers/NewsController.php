<?php

namespace backend\controllers;

use backend\models\NewsSearch;
use common\components\ErrorHelper;
use common\models\News;
use Exception;
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

        $this->view->title = 'News';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record saved');

            return $this->redirect(['view', 'id' => $model->news_id]);
        }

        $this->view->title = 'Create news';
        $this->view->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = News::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Record saved');

            return $this->redirect(['view', 'id' => $model->news_id]);
        }

        $this->view->title = 'Update news';
        $this->view->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->news_title,
            'url' => ['view', 'id' => $model->news_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $model = News::find()->where(['news_id' => $id])->one();

        try {
            $this->notFound($model);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        $this->view->title = $model->news_title;
        $this->view->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = News::find()->where(['news_id' => $id])->one();

        try {
            $this->notFound($model);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Record saved');
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['index']);
    }
}
