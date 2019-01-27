<?php

namespace backend\controllers;

use backend\models\TeamAskSearch;
use common\components\ErrorHelper;
use common\models\Team;
use common\models\TeamAsk;
use Exception;
use Yii;

/**
 * Class TeamAskController
 * @package backend\controllers
 */
class TeamAskController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TeamAskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Заявки на команды';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return bool|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = TeamAsk::find()
            ->where(['team_ask_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $teamToEmploy = Team::find()
            ->where(['team_id' => $model->team_ask_team_id, 'team_user_id' => 0])
            ->limit(1)
            ->one();
        if (!$teamToEmploy) {
            $model->delete();
            return $this->redirect(['team-ask/index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->team_ask_leave_id) {
                $teamToFire = Team::find()
                    ->where(['team_id' => $model->team_ask_leave_id])
                    ->limit(1)
                    ->one();
                if ($teamToFire) {
                    $teamToFire->managerFire();
                }
            }

            $teamToEmploy->managerEmploy($model->team_ask_user_id);

            TeamAsk::deleteAll(['team_ask_team_id' => $model->team_ask_team_id]);
            TeamAsk::deleteAll(['team_ask_user_id' => $model->team_ask_user_id]);
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
            return $this->redirect(['team-ask/index']);
        }

        $transaction->commit();
        return $this->redirect(['team-ask/index']);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = TeamAsk::find()
            ->where(['team_ask_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $this->view->title = $model->team->team_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Заявки на команды', 'url' => ['team-ask/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
