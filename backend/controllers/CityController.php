<?php

namespace backend\controllers;

use backend\models\CitySearch;
use common\models\City;
use common\models\Country;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class CityController
 * @package backend\controllers
 */
class CityController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Города';
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
        $model = City::find()->where(['city_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['city/view', 'id' => $model->city_id]);
        }

        $countryArray = ArrayHelper::map(
            Country::find()
                ->where(['!=', 'country_id', 0])
                ->orderBy(['country_name' => SORT_ASC])
                ->all(),
            'country_id',
            'country_name'
        );

        $this->view->title = 'Редактирование города';
        $this->view->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['city/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->city_name,
            'url' => ['city/view', 'id' => $model->city_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
            'countryArray' => $countryArray,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = City::find()->where(['city_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->city_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['city/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
