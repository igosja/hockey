<?php

namespace backend\controllers;

use backend\models\FinanceTextSearch;
use common\components\ErrorHelper;
use common\models\FinanceText;
use Exception;
use Throwable;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class FinanceTextController
 * @package backend\controllers
 */
class FinanceTextController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FinanceTextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Описания финансовых операций';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new FinanceText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['finance-text/view', 'id' => $model->finance_text_id]);
        }

        $this->view->title = 'Создание описания финансовых операций';
        $this->view->params['breadcrumbs'][] = ['label' => 'Описания финансовых операций', 'url' => ['finance-text/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Exception
     */
    public function actionUpdate(int $id)
    {
        $model = FinanceText::find()
            ->where(['finance_text_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['finance-text/view', 'id' => $model->finance_text_id]);
        }

        $this->view->title = 'Редактирование описания финансовых операций';
        $this->view->params['breadcrumbs'][] = ['label' => 'Описания финансовых операций', 'url' => ['finance-text/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->finance_text_text,
            'url' => ['finance-text/view', 'id' => $model->finance_text_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = FinanceText::find()
            ->where(['finance_text_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $this->view->title = $model->finance_text_text;
        $this->view->params['breadcrumbs'][] = ['label' => 'Описания финансовых операций', 'url' => ['finance-text/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id)
    {
        $model = FinanceText::find()
            ->where(['finance_text_id' => $id])
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

        return $this->redirect(['finance-text/index']);
    }
}
