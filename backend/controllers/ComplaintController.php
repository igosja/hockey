<?php

namespace backend\controllers;

use backend\models\ComplaintSearch;
use common\components\ErrorHelper;
use common\models\Complaint;
use Exception;
use Yii;
use yii\web\Response;

/**
 * Class ComplaintController
 * @package backend\controllers
 */
class ComplaintController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComplaintSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Жалобы на форуме';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Complaint::find()->where(['complaint_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $model->complaint_ready = time();
        try {
            $model->save();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        $this->setSuccessFlash();
        return $this->redirect(['complaint/index']);
    }
}
