<?php

namespace backend\controllers;

use backend\models\StageSearch;
use common\components\ErrorHelper;
use common\models\Stage;
use Throwable;
use Yii;

/**
 * Class StageController
 * @package backend\controllers
 */
class StageController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Стадии соревнований';
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
        $model = new Stage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['stage/view', 'id' => $model->stage_id]);
        }

        $this->view->title = 'Создание стадии соревнований';
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадии соревнований', 'url' => ['stage/index']];
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
        $model = Stage::find()->where(['stage_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['stage/view', 'id' => $model->stage_id]);
        }

        $this->view->title = 'Редактирование причины блокировки';
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадии соревнований', 'url' => ['stage/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->stage_name,
            'url' => ['stage/view', 'id' => $model->stage_id]
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
        $model = Stage::find()->where(['stage_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->stage_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадии соревнований', 'url' => ['stage/index']];
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
        $model = Stage::find()->where(['stage_id' => $id])->limit(1)->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['stage/index']);
    }
}
