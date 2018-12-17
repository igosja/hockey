<?php

namespace frontend\controllers;

use common\models\Building;
use common\models\Loan;
use common\models\Player;
use common\models\Training;
use common\models\Transfer;
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

        $model = new \frontend\models\Training();
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

        $team = $this->myTeam;

        $data = Yii::$app->request->get();

        $confirmData = [
            'position' => [],
            'power' => [],
            'special' => [],
            'price' => 0,
        ];

        $playerIdArray = [];

        if (isset($data['power'])) {
            foreach ($data['power'] as $playerId => $power) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который находиться в аренде.');
                    return $this->redirect(['transfer/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if (!$transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['transfer/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if (!$loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['transfer/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['transfer/index']);
                }

                $confirmData['power'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                ];

                $confirmData['price'] = $confirmData['price'] + $team->baseTraining->base_training_power_price;
            }
        }

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('train', [
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
