<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Building;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Player;
use common\models\Scout;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class ScoutController
 * @package frontend\controllers
 */
class ScoutController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
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
     * @return string|Response
     */
    public function actionIndex()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        $model = new \frontend\models\Scout();
        if ($model->load(Yii::$app->request->post(), '')) {
            return $this->redirect($model->redirectUrl());
        }

        $scoutArray = Scout::find()
            ->where(['scout_team_id' => $team->team_id, 'scout_ready' => 0])
            ->orderBy(['scout_id' => SORT_ASC])
            ->all();

        $query = Player::find()
            ->joinWith(['country'])
            ->with([
                'playerPosition.position',
                'playerSpecial.special',
            ])
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'country' => [
                        'asc' => ['country_name' => SORT_ASC],
                        'desc' => ['country_name' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'power' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_squad_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_squad_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle($team->fullName() . '. ???????????????? ????????????????????');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'scoutArray' => $scoutArray,
            'team' => $team,
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionStudy()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        if ($this->isOnBuilding()) {
            $this->setErrorFlash('???? ???????? ???????????? ???????? ??????????????????????????.');
            return $this->redirect(['scout/index']);
        }

        $data = Yii::$app->request->get();

        $confirmData = [
            'style' => [],
            'price' => 0,
        ];

        if (isset($data['style'])) {
            foreach ($data['style'] as $playerId => $style) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id])
                    ->andWhere(['<', 'player_date_no_action', time()])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('?????????? ???????????? ??????????????????????.');
                    return $this->redirect(['scout/index']);
                }

                $scout = Scout::find()
                    ->where(['scout_player_id' => $playerId, 'scout_ready' => 0])
                    ->count();
                if ($scout) {
                    $this->setErrorFlash('???????????? ???????????? ???????????? ???????????????????????? ?????????????? ?????????????????? ??????.');
                    return $this->redirect(['scout/index']);
                }

                if (2 == $player->countScout()) {
                    $this->setErrorFlash('?????????? ?????? ?????????????????? ????????????.');
                    return $this->redirect(['scout/index']);
                }

                $confirmData['style'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                ];

                $confirmData['price'] = $confirmData['price'] + $team->baseScout->base_scout_my_style_price;
            }
        }

        if (count($confirmData['style']) > $team->availableScout()) {
            $this->setErrorFlash('?? ?????? ???????????????????????? ???????????? ?????? ????????????????.');
            return $this->redirect(['scout/index']);
        } elseif ($confirmData['price'] > $team->team_finance) {
            $this->setErrorFlash('?? ?????? ???????????????????????? ?????????? ?????? ????????????????.');
            return $this->redirect(['scout/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($confirmData['style'] as $style) {
                    $model = new Scout();
                    $model->scout_player_id = $style['id'];
                    $model->scout_style = 1;
                    $model->scout_season_id = $this->seasonId;
                    $model->scout_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_SCOUT_STYLE,
                        'finance_player_id' => $style['id'],
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$team->baseScout->base_scout_my_style_price,
                        'finance_value_after' => $team->team_finance - $team->baseScout->base_scout_my_style_price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $team->baseScout->base_scout_my_style_price;
                    $team->save(true, ['team_finance']);
                }

                $transaction->commit();

                $this->setSuccessFlash('???????????????? ?????????????? ????????????????.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['scout/index']);
        }

        $this->setSeoTitle($team->fullName() . '. ???????????????? ????????????????????');

        return $this->render('study', [
            'confirmData' => $confirmData,
            'team' => $team,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionCancel($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        $scout = Scout::find()
            ->where(['scout_id' => $id, 'scout_ready' => 0, 'scout_team_id' => $team->team_id])
            ->limit(1)
            ->one();
        if (!$scout) {
            $this->setErrorFlash('???????????????? ?????????????? ??????????????????????.');
            return $this->redirect(['scout/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $scout->delete();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_SCOUT_STYLE,
                    'finance_player_id' => $scout->scout_player_id,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => $team->baseScout->base_scout_my_style_price,
                    'finance_value_after' => $team->team_finance + $team->baseScout->base_scout_my_style_price,
                    'finance_value_before' => $team->team_finance,
                ]);

                $team->team_finance = $team->team_finance + $team->baseScout->base_scout_my_style_price;
                $team->save(true, ['team_finance']);

                $transaction->commit();

                $this->setSuccessFlash('???????????????? ?????????????? ????????????????.');
            } catch (Throwable $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['scout/index']);
        }

        $this->setSeoTitle('???????????? ????????????????. ' . $team->fullName());

        return $this->render('cancel', [
            'id' => $id,
            'team' => $team,
            'scout' => $scout,
        ]);
    }

    /**
     * @return bool
     */
    private function isOnBuilding()
    {
        if (!$this->myTeam->buildingBase) {
            return false;
        }

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::SCOUT])) {
            return false;
        }

        return true;
    }
}
