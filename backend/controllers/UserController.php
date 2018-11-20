<?php

namespace backend\controllers;

use backend\models\UserSearch;
use Yii;

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
}
