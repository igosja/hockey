<?php

namespace backend\controllers;

use backend\models\NewsSearch;
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
