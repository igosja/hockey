<?php

namespace backend\controllers;

use backend\models\NewsSearch;
use common\components\ErrorHelper;
use common\models\News;
use Exception;
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

    }

    public function actionUpdate($id)
    {

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

    }
}
