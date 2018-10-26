<?php

namespace backend\controllers;

use backend\models\RuleSearch;
use common\components\ErrorHelper;
use common\models\Rule;
use Throwable;
use Yii;

/**
 * Class RuleController
 * @package backend\controllers
 */
class RuleController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new RuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Правила';
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
        $model = new Rule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['view', 'id' => $model->rule_id]);
        }

        $this->view->title = 'Создание правила';
        $this->view->params['breadcrumbs'][] = ['label' => 'Правила', 'url' => ['rule/index']];
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
        $model = Rule::find()->where(['rule_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['view', 'id' => $model->rule_id]);
        }

        $this->view->title = 'Редактирование правила';
        $this->view->params['breadcrumbs'][] = ['label' => 'Правила', 'url' => ['rule/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->rule_title,
            'url' => ['rule/view', 'id' => $model->rule_id]
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
        $model = Rule::find()->where(['rule_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->rule_title;
        $this->view->params['breadcrumbs'][] = ['label' => 'Правила', 'url' => ['rule/index']];
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
        $model = Rule::find()->where(['rule_id' => $id])->limit(1)->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['rule/index']);
    }
}
