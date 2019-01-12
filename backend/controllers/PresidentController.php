<?php

namespace backend\controllers;

use backend\models\PresidentSearch;
use Yii;
use yii\web\Response;

/**
 * Class PresidentController
 * @package backend\controllers
 */
class PresidentController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PresidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Пользователи';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionView($id)
    {
        return $this->redirect(['user/view', 'id' => $id]);
    }
}
