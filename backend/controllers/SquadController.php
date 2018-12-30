<?php

namespace backend\controllers;

use backend\models\SquadSearch;
use common\models\Squad;
use Yii;

/**
 * Class SquadController
 * @package backend\controllers
 */
class SquadController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new SquadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Составы';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate(int $id)
    {
        $model = Squad::find()->where(['squad_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['squad/view', 'id' => $model->squad_id]);
        }

        $this->view->title = 'Редактирование состава';
        $this->view->params['breadcrumbs'][] = ['label' => 'Составы', 'url' => ['squad/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->squad_name,
            'url' => ['squad/view', 'id' => $model->squad_id]
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
        $model = Squad::find()->where(['squad_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->squad_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Составы', 'url' => ['squad/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
