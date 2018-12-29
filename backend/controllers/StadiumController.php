<?php

namespace backend\controllers;

use backend\models\StadiumSearch;
use common\models\City;
use common\models\Stadium;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class StadiumController
 * @package backend\controllers
 */
class StadiumController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new StadiumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Стадионы';
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
        $model = Stadium::find()->where(['stadium_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['stadium/view', 'id' => $model->stadium_id]);
        }

        $cityArray = ArrayHelper::map(
            City::find()
                ->where(['!=', 'city_id', 0])
                ->orderBy(['city_name' => SORT_ASC])
                ->all(),
            'city_id',
            'city_name'
        );

        $this->view->title = 'Редактирование стадиона';
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадионы', 'url' => ['stadium/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->stadium_name,
            'url' => ['stadium/view', 'id' => $model->stadium_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
            'cityArray' => $cityArray,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = Stadium::find()->where(['stadium_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->stadium_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадионы', 'url' => ['stadium/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
