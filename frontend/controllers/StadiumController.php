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
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        $stadium = new Stadium(['stadium' => $team->stadium]);
        if (!$stadium->load(Yii::$app->request->post())) {
            return $this->redirect(['stadium/increase']);
        }

        $stadium->scenario = Stadium::SCENARIO_INCREASE;
        if (!$stadium->validate()) {
            $this->setErrorFlash(ErrorHelper::modelErrorsToString($stadium));
            return $this->redirect(['stadium/increase']);
        }


        $buildingStadiumPrice = floor((pow($stadium->capacity, 1.1) - pow($team->stadium->stadium_capacity,
                    1.1)) * Stadium::ONE_SIT_PRICE_BUY);
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
}
