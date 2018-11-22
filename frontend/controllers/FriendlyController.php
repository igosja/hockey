<?php

namespace frontend\controllers;

use common\models\Team;
use Yii;

/**
 * Class FriendlyController
 * @package frontend\controllers
 */
class FriendlyController extends AbstractController
{
    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        Team::updateAll(['team_friendly_status_id' => 2]);
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

        $this->setSeoTitle('Тенировка хоккеистов');

        return $this->render('index', [
            'team' => $team,
        ]);
    }
}
