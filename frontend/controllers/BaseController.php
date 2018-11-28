<?php

namespace frontend\controllers;

use common\models\Team;

/**
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends AbstractController
{
    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $team = Team::find()
            ->where(['team_id' => $id])
            ->one();
        $this->notFound($team);

        return $this->render('view', [
            'team' => $team,
        ]);
    }
}
