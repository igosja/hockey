<?php

namespace backend\controllers;

use backend\models\PollSearch;
use common\components\ErrorHelper;
use common\models\Poll;
use common\models\PollAnswer;
use common\models\PollStatus;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Class PollController
 * @package backend\controllers
 */
class PollController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Опросы';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Poll();

        try {
            if ($model->savePoll()) {
                $this->setSuccessFlash();
                return $this->redirect(['poll/view', 'id' => $model->poll_id]);
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        $this->view->title = 'Создание опроса';
        $this->view->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['poll/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Throwable
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = Poll::find()->where(['poll_id' => $id])->limit(1)->one();
        $this->notFound($model);
        $model->prepareForm();

        if ($model->savePoll()) {
            $this->setSuccessFlash();
            return $this->redirect(['poll/view', 'id' => $model->poll_id]);
        }

        $this->view->title = 'Редактирование опроса';
        $this->view->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['poll/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->poll_text,
            'url' => ['poll/view', 'id' => $model->poll_id]
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
        $model = Poll::find()->where(['poll_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $query = PollAnswer::find()
            ->where(['poll_answer_poll_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->view->title = $model->poll_text;
        $this->view->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['poll/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = Poll::find()->where(['poll_id' => $id])->limit(1)->one();
        $this->notFound($model);

        try {
            if ($model->delete()) {
                $this->setSuccessFlash();
            }
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['poll/index']);
    }

    /**
     * @param int $id
     * @return Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionApprove(int $id): Response
    {
        $model = Poll::find()->where(['poll_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $model->poll_poll_status_id = PollStatus::OPEN;
        try {
            $model->save();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        $this->setSuccessFlash();
        return $this->redirect(['poll/index']);
    }
}
