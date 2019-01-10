<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\BuildingStadium;
use common\models\ConstructionType;
use common\models\Finance;
use common\models\FinanceText;
use Exception;
use frontend\models\Stadium;
use Throwable;
use Yii;
use yii\filters\AccessControl;

/**
 * Class StadiumController
 * @package frontend\controllers
 */
class StadiumController extends AbstractController
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
     * @return string|\yii\web\Response
     */
    public function actionIncrease()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $model = new Stadium(['stadium' => $team->stadium]);
        $model->scenario = Stadium::SCENARIO_INCREASE;

        $this->setSeoTitle($team->stadium->stadium_name . '. Увеличение стадиона');

        return $this->render('increase', [
            'model' => $model,
            'team' => $team,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionDecrease()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $model = new Stadium(['stadium' => $team->stadium]);
        $model->scenario = Stadium::SCENARIO_DECREASE;

        $this->setSeoTitle($team->stadium->stadium_name . '. Уменьшение стадиона');

        return $this->render('decrease', [
            'model' => $model,
            'team' => $team,
        ]);
    }

    /**
     * @throws \yii\db\Exception
     * @return string|\yii\web\Response
     */
    public function actionBuild()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($team->buildingStadium) {
            $this->setErrorFlash('На стадионе уже идет строительство.');
            return $this->redirect(['stadium/increase']);
        }

        $stadium = new Stadium(['stadium' => $team->stadium]);
        if (!$stadium->load(Yii::$app->request->get())) {
            return $this->redirect(['stadium/increase']);
        }

        $stadium->scenario = Stadium::SCENARIO_INCREASE;
        if (!$stadium->validate()) {
            $this->setErrorFlash(ErrorHelper::modelErrorsToString($stadium));
            return $this->redirect(['stadium/increase']);
        }


        $buildingStadiumPrice = floor(
            (pow($stadium->capacity, 1.1) - pow($team->stadium->stadium_capacity, 1.1)) * Stadium::ONE_SIT_PRICE_BUY
        );
        $buildingStadiumDay = ceil(($stadium->capacity - $team->stadium->stadium_capacity) / 1000);

        if ($buildingStadiumPrice > $team->team_finance) {
            $this->setErrorFlash('Для строительства нужно <span class="strong">' . FormatHelper::asCurrency($buildingStadiumPrice) . '</span>.');
            return $this->redirect(['stadium/increase']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new BuildingStadium();
                $model->building_stadium_capacity = $stadium->capacity;
                $model->building_stadium_construction_type_id = ConstructionType::BUILD;
                $model->building_stadium_day = $buildingStadiumDay;
                $model->building_stadium_team_id = $team->team_id;
                $model->save();

                Finance::log([
                    'finance_capacity' => $stadium->capacity,
                    'finance_finance_text_id' => FinanceText::OUTCOME_BUILDING_STADIUM,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => -$buildingStadiumPrice,
                    'finance_value_after' => $team->team_finance - $buildingStadiumPrice,
                    'finance_value_before' => $team->team_finance,
                ]);

                $team->team_finance = $team->team_finance - $buildingStadiumPrice;
                $team->save(true, ['team_finance']);
                $transaction->commit();

                $this->setSuccessFlash('Строительство успешно началось.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }
            return $this->redirect(['stadium/increase']);
        }

        $message = 'Увеличение стадиона до <span class="strong">' . $stadium->capacity
            . '</span> мест будет стоить <span class="strong">' . FormatHelper::asCurrency($buildingStadiumPrice)
            . '</span> и займет <span class="strong">' . $buildingStadiumDay
            . '</span> дн.';


        $this->setSeoTitle($team->stadium->stadium_name . '. Увеличение стадиона');

        return $this->render('build', [
            'message' => $message,
            'model' => $stadium,
            'team' => $team,
        ]);
    }

    /**
     * @throws \yii\db\Exception
     * @return string|\yii\web\Response
     */
    public function actionDestroy()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($team->buildingStadium) {
            $this->setErrorFlash('На стадионе уже идет строительство.');
            return $this->redirect(['stadium/decrease']);
        }

        $stadium = new Stadium(['stadium' => $team->stadium]);
        if (!$stadium->load(Yii::$app->request->get())) {
            return $this->redirect(['stadium/decrease']);
        }

        $stadium->scenario = Stadium::SCENARIO_DECREASE;
        if (!$stadium->validate()) {
            $this->setErrorFlash(ErrorHelper::modelErrorsToString($stadium));
            return $this->redirect(['stadium/decrease']);
        }

        $buildingStadiumPrice = floor(
            (pow($team->stadium->stadium_capacity, 1.1) - pow($stadium->capacity, 1.1)) * Stadium::ONE_SIT_PRICE_SELL
        );
        $buildingStadiumDay = 1;

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new BuildingStadium();
                $model->building_stadium_capacity = $stadium->capacity;
                $model->building_stadium_construction_type_id = ConstructionType::DESTROY;
                $model->building_stadium_day = $buildingStadiumDay;
                $model->building_stadium_team_id = $team->team_id;
                $model->save();

                Finance::log([
                    'finance_capacity' => $stadium->capacity,
                    'finance_finance_text_id' => FinanceText::INCOME_BUILDING_STADIUM,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => $buildingStadiumPrice,
                    'finance_value_after' => $team->team_finance + $buildingStadiumPrice,
                    'finance_value_before' => $team->team_finance,
                ]);

                $team->team_finance = $team->team_finance + $buildingStadiumPrice;
                $team->save(true, ['team_finance']);
                $transaction->commit();

                $this->setSuccessFlash('Строительство успешно началось.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }
            return $this->redirect(['stadium/increase']);
        }

        $message = 'При уменьшении стадиона до <span class="strong">' . $stadium->capacity
            . '</span> мест вы получите компенсацию <span class="strong">' . FormatHelper::asCurrency($buildingStadiumPrice)
            . '</span> и займет <span class="strong">' . $buildingStadiumDay
            . '</span> дн.';


        $this->setSeoTitle($team->stadium->stadium_name . '. Уменьшения стадиона');

        return $this->render('destroy', [
            'message' => $message,
            'model' => $stadium,
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCancel($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $buildingStadium = BuildingStadium::find()
            ->where([
                'building_stadium_id' => $id,
                'building_stadium_ready' => 0,
                'building_stadium_team_id' => $team->team_id,
            ])
            ->limit(1)
            ->one();
        if (!$buildingStadium) {
            $this->setErrorFlash('Строительство выбрано неправильно.');
            return $this->redirect(['stadium/increase']);
        }

        $finance = Finance::find()
            ->where([
                'finance_finance_text_id' => [FinanceText::INCOME_BUILDING_STADIUM, FinanceText::OUTCOME_BUILDING_STADIUM],
                'finance_team_id' => $team->team_id,
            ])
            ->orderBy(['finance_id' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$finance) {
            $this->setErrorFlash('Строительство выбрано неправильно.');
            return $this->redirect(['stadium/increase']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($finance->finance_value < 0) {
                    $textId = FinanceText::INCOME_BUILDING_STADIUM;
                } else {
                    $textId = FinanceText::OUTCOME_BUILDING_STADIUM;
                }

                $buildingStadium->delete();

                Finance::log([
                    'finance_capacity' => $team->stadium->stadium_capacity,
                    'finance_finance_text_id' => $textId,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => -$finance->finance_value,
                    'finance_value_after' => $team->team_finance - $finance->finance_value,
                    'finance_value_before' => $team->team_finance,
                ]);

                $team->team_finance = $team->team_finance - $finance->finance_value;
                $team->save(true, ['team_finance']);
                $transaction->commit();

                $this->setSuccessFlash('Строительство успешно отменено.');
            } catch (Throwable $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['stadium/increase']);
        }

        $this->setSeoTitle('Отмена строительства стадиона ' . $team->stadium->stadium_name);

        return $this->render('cancel', [
            'id' => $id,
            'price' => -$finance->finance_value,
            'team' => $team,
        ]);
    }
}
