<?php

namespace backend\controllers;

use backend\models\BlockReasonSearch;
use common\components\ErrorHelper;
use common\models\BlockReason;
use Throwable;
use Yii;

/**
 * Class BlockReasonController
 * @package backend\controllers
 */
class BlockReasonController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlockReasonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Причины блокировки';
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
        $model = new BlockReason();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['block-reason/view', 'id' => $model->block_reason_id]);
        }

        $this->view->title = 'Создание причины блокировки';
        $this->view->params['breadcrumbs'][] = ['label' => 'Причины блокировки', 'url' => ['block-reason/index']];
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
        $model = BlockReason::find()->where(['block_reason_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['block-reason/view', 'id' => $model->block_reason_id]);
        }

        $this->view->title = 'Редактирование причины блокировки';
        $this->view->params['breadcrumbs'][] = ['label' => 'Причины блокировки', 'url' => ['block-reason/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->block_reason_text,
            'url' => ['block-reason/view', 'id' => $model->block_reason_id]
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
        $model = BlockReason::find()->where(['block_reason_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->block_reason_text;
        $this->view->params['breadcrumbs'][] = ['label' => 'Причины блокировки', 'url' => ['block-reason/index']];
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
        $model = BlockReason::find()->where(['block_reason_id' => $id])->limit(1)->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['block-reason/index']);
    }
}
