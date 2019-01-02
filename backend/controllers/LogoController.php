<?php

namespace backend\controllers;

use common\models\Logo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Class LogoController
 * @package backend\controllers
 */
class LogoController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Logo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->view->title = 'Логотипы команд';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = Logo::find()->where(['logo_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->team->team_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Логотипы команд', 'url' => ['logo/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAccept(int $id): Response
    {
        $model = Logo::find()->where(['logo_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $file = Yii::getAlias('@frontend') . '/web/upload/img/team/125/' . $model->team->team_id . '.png';
        if (file_exists($file)) {
            rename($file, Yii::getAlias('@frontend') . '/web/img/team/125/' . $model->team->team_id . '.png');
        }

        $model->delete();
        $this->setSuccessFlash();
        return $this->redirect(['logo/index']);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = Logo::find()->where(['logo_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $model->delete();
        $this->setSuccessFlash();
        return $this->redirect(['logo/index']);
    }
}
