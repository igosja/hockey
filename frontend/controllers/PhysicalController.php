<?php

namespace frontend\controllers;

use common\models\Player;
use common\models\Team;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class PhysicalController
 * @package frontend\controllers
 */
class PhysicalController extends AbstractController
{
    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->forbiddenAuth();
        }

        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = Team::find()
            ->where(['team_id' => $this->myTeam->team_id])
            ->limit(1)
            ->one();
        $this->notFound($team);

        $query = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Тенировка хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'team' => $team,
        ]);
    }
}
