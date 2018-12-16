<?php

namespace frontend\controllers;

use common\models\Building;
use common\models\Player;
use frontend\models\Training;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class TrainingController
 * @package frontend\controllers
 */
class TrainingController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $model = new Training();
        if ($model->load(Yii::$app->request->post(), '')) {
            return $this->redirect($model->redirectUrl());
        }

        $team = $this->myTeam;

        $query = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_position_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'team' => $team,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionTrain()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        print '<pre>';
        print_r(Yii::$app->request->get());
        exit;

        $team = $this->myTeam;

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'team' => $team,
        ]);
    }

    /**
     * @return bool
     */
    private function isOnBuilding(): bool
    {
        if (!$this->myTeam->buildingBase) {
            return false;
        }

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::TRAINING])) {
            return false;
        }

        return true;
    }
}
