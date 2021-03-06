<?php

namespace backend\controllers;

use common\models\Logo;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
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
    public function actionIndex()
    {
        $query = Logo::find()
            ->where(['!=', 'logo_team_id', 0]);
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
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Logo::find()
            ->where(['logo_id' => $id])
            ->andWhere(['!=', 'logo_team_id', 0])
            ->limit(1)
            ->one();
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
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionAccept($id)
    {
        $model = Logo::find()
            ->where(['logo_id' => $id])
            ->andWhere(['!=', 'logo_team_id', 0])
            ->limit(1)
            ->one();
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
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = Logo::find()
            ->where(['logo_id' => $id])
            ->andWhere(['!=', 'logo_team_id', 0])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $model->delete();
        $this->setSuccessFlash();
        return $this->redirect(['logo/index']);
    }
}
