<?php

namespace backend\controllers;

use backend\models\TournamentTypeSearch;
use common\components\ErrorHelper;
use common\models\TournamentType;
use Throwable;
use Yii;

/**
 * Class TournamentTypeController
 * @package backend\controllers
 */
class TournamentTypeController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TournamentTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Типы турниров';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new TournamentType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['tournament-type/view', 'id' => $model->tournament_type_id]);
        }

        $this->view->title = 'Создание типа турниров';
        $this->view->params['breadcrumbs'][] = ['label' => 'Типы турниров', 'url' => ['tournament-type/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $model = TournamentType::find()
            ->where(['tournament_type_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['tournament-type/view', 'id' => $model->tournament_type_id]);
        }

        $this->view->title = 'Редактирование типа турниров';
        $this->view->params['breadcrumbs'][] = ['label' => 'Типы турниров', 'url' => ['tournament-type/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->tournament_type_name,
            'url' => ['tournament-type/view', 'id' => $model->tournament_type_id]
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
    public function actionView($id)
    {
        $model = TournamentType::find()
            ->where(['tournament_type_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $this->view->title = $model->tournament_type_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Типы турниров', 'url' => ['tournament-type/index']];
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
    public function actionDelete($id)
    {
        $model = TournamentType::find()
            ->where(['tournament_type_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['tournament-type/index']);
    }
}
