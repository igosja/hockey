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

/**
 * Class ScoutController
 * @package frontend\controllers
 */
class ScoutController extends AbstractController
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
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_position_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Изучение хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'scoutArray' => $scoutArray,
            'team' => $team,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionStudy()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($this->isOnBuilding()) {
            $this->setErrorFlash('На базе сейчас идет строительство.');
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
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Игрок выбран неправильно.');
                    return $this->redirect(['scout/index']);
                }

                $scout = Scout::find()
                    ->where(['scout_player_id' => $playerId, 'scout_ready' => 0])
                    ->count();
                if ($scout) {
                    $this->setErrorFlash('Одного игрока нельзя одновременно изучать несколько раз.');
                    return $this->redirect(['scout/index']);
                }

                if ($player->countScout()) {
                    $this->setErrorFlash('Игрок уже полностью изучен.');
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
            $this->setErrorFlash('У вас недостаточно стилей для изучения.');
            return $this->redirect(['scout/index']);
        } elseif ($confirmData['price'] > $team->team_finance) {
            $this->setErrorFlash('У вас недостаточно денег для изучения.');
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
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$team->baseScout->base_scout_my_style_price,
                        'finance_value_after' => $team->team_finance - $team->baseScout->base_scout_my_style_price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $team->baseScout->base_scout_my_style_price;
                    $team->save(true, ['team_finance']);
                }

                $transaction->commit();

                $this->setSuccessFlash('Изучение успешно началось.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['scout/index']);
        }

        $this->setSeoTitle($team->fullName() . '. Изучение хоккеистов');

        return $this->render('study', [
            'confirmData' => $confirmData,
            'team' => $team,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCancel(int $id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $scout = Scout::find()
            ->where(['scout_id' => $id, 'scout_ready' => 0, 'scout_team_id' => $team->team_id])
            ->limit(1)
            ->one();
        if (!$scout) {
            $this->setErrorFlash('Изучение выбрано неправильно.');
            return $this->redirect(['scout/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $scout->delete();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_SCOUT_STYLE,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => $team->baseScout->base_scout_my_style_price,
                    'finance_value_after' => $team->team_finance + $team->baseScout->base_scout_my_style_price,
                    'finance_value_before' => $team->team_finance,
                ]);

                $team->team_finance = $team->team_finance + $team->baseScout->base_scout_my_style_price;
                $team->save(true, ['team_finance']);

                $transaction->commit();

                $this->setSuccessFlash('Изучение успешно отменено.');
            } catch (Throwable $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['scout/index']);
        }

        $this->setSeoTitle('Отмена изучения. ' . $team->fullName());

        return $this->render('cancel', [
            'id' => $id,
            'team' => $team,
            'scout' => $scout,
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

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::SCOUT])) {
            return false;
        }

        return true;
    }
}
