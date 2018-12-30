<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Base;
use common\models\BaseMedical;
use common\models\BasePhysical;
use common\models\BaseSchool;
use common\models\BaseScout;
use common\models\BaseTraining;
use common\models\Building;
use common\models\History;
use common\models\HistoryText;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;

/**
 * Class BaseFreeController
 * @package frontend\controllers
 */
class BaseFreeController extends AbstractController
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
     * @return string
     */
    public function actionView(): string
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $linkBaseArray = [];
        $linkTrainingArray = [];
        $linkMedicalArray = [];
        $linkPhysicalArray = [];
        $linkSchoolArray = [];
        $linkScoutArray = [];

        $delBase = false;
        $delMedical = false;
        $delPhysical = false;
        $delSchool = false;
        $delScout = false;
        $delTraining = false;

        if ($team->buildingBase && Building::BASE == $team->buildingBase->building_base_building_id) {
            $linkBaseArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
            $linkTrainingArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
            $linkMedicalArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
            $linkPhysicalArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
            $linkSchoolArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
            $linkScoutArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);

            $delBase = true;
            $delMedical = true;
            $delPhysical = true;
            $delSchool = true;
            $delScout = true;
            $delTraining = true;
        } else {
            if ($team->base->base_level < Building::MAX_LEVEL) {
                $linkBaseArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::BASE],
                    ['class' => 'btn margin']
                );
            }

            if ($team->buildingBase && Building::TRAINING == $team->buildingBase->building_base_building_id) {
                $linkTrainingArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
                $delTraining = true;
            } elseif ($team->baseTraining->base_training_level < Building::MAX_LEVEL) {
                $linkTrainingArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::TRAINING],
                    ['class' => 'btn margin']
                );
            }

            if ($team->buildingBase && Building::PHYSICAL == $team->buildingBase->building_base_building_id) {
                $linkPhysicalArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
                $delPhysical = true;
            } elseif ($team->basePhysical->base_physical_level < Building::MAX_LEVEL) {
                $linkPhysicalArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::PHYSICAL],
                    ['class' => 'btn margin']
                );
            }

            if ($team->buildingBase && Building::SCHOOL == $team->buildingBase->building_base_building_id) {
                $linkSchoolArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
                $delSchool = true;
            } elseif ($team->baseSchool->base_school_level < Building::MAX_LEVEL) {
                $linkSchoolArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::SCHOOL],
                    ['class' => 'btn margin']
                );
            }

            if ($team->buildingBase && Building::SCOUT == $team->buildingBase->building_base_building_id) {
                $linkScoutArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
                $delScout = true;
            } elseif ($team->baseScout->base_scout_level < Building::MAX_LEVEL) {
                $linkScoutArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::SCOUT],
                    ['class' => 'btn margin']
                );
            }

            if ($team->buildingBase && Building::MEDICAL == $team->buildingBase->building_base_building_id) {
                $linkMedicalArray[] = Html::a('Идет строительство', 'javascript:', ['class' => 'btn margin']);
                $delMedical = true;
            } elseif ($team->baseMedical->base_medical_level < Building::MAX_LEVEL) {
                $linkMedicalArray[] = Html::a(
                    'Строить',
                    ['base-free/build', 'building' => Building::MEDICAL],
                    ['class' => 'btn margin']
                );
            }
        }

        $this->setSeoTitle('База команды ' . $team->fullName());

        return $this->render('view', [
            'delBase' => $delBase,
            'delMedical' => $delMedical,
            'delPhysical' => $delPhysical,
            'delSchool' => $delSchool,
            'delScout' => $delScout,
            'delTraining' => $delTraining,
            'linkBaseArray' => $linkBaseArray,
            'linkMedicalArray' => $linkMedicalArray,
            'linkPhysicalArray' => $linkPhysicalArray,
            'linkSchoolArray' => $linkSchoolArray,
            'linkScoutArray' => $linkScoutArray,
            'linkTrainingArray' => $linkTrainingArray,
            'myTeam' => $this->myTeam,
            'team' => $team,
        ]);
    }

    /**
     * @param int $building
     * @throws \yii\db\Exception
     * @return string|\yii\web\Response
     */
    public function actionBuild(int $building)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($team->buildingBase) {
            $this->setErrorFlash('На базе уже идет строительство.');
            return $this->redirect(['base-free/view']);
        }

        if (Building::BASE == $building) {
            $level = $team->base->base_level + 1;
            $base = Base::find()
                ->where(['base_level' => $level])
                ->limit(1)
                ->one();
            if (!$base) {
                $this->setErrorFlash('Вы имеете здание максимального уровня.');
                return $this->redirect(['base-free/view']);
            } elseif ($team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base-free/view']);
            } elseif ($team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base-free/view']);
            } elseif ($team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base-free/view']);
            } elseif ($base->base_slot_min > $team->baseUsed()) {
                $this->setErrorFlash('Минимальное количество занятых слотов должно быть не меньше <span class="strong">' . $base->base_slot_min . '</span>.');
                return $this->redirect(['base-free/view']);
            } elseif (!$team->team_free_base) {
                $this->setErrorFlash('У вас нет бесплатных улучшений базы.');
                return $this->redirect(['base-free/view']);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    History::log([
                        'history_building_id' => $building,
                        'history_history_text_id' => HistoryText::BUILDING_UP,
                        'history_team_id' => $team->team_id,
                        'history_value' => $base->base_level,
                    ]);

                    $team->team_base_id++;
                    $team->team_free_base--;
                    $team->save(true, ['team_base_id', 'team_free_base']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство прошло успешно.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
                return $this->redirect(['base-free/view']);
            }

            $message = 'Улучшение базы <span class="strong">'
                . $base->base_level
                . '</span> уровня произойдет мгновенно.';
        } else {
            $base = Building::find()
                ->where(['building_id' => $building])
                ->one();

            if (!$base) {
                $this->setErrorFlash('Тип строения выбран неправильно.');
                return $this->redirect(['base-free/view']);
            } elseif (Building::TRAINING == $building && $team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base-free/view']);
            } elseif (Building::SCHOOL == $building && $team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base-free/view']);
            } elseif (Building::SCOUT == $building && $team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base-free/view']);
            }

            $baseLevel = $base->building_name . '_base_level';
            $baseTeam = 'team_' . $base->building_name . '_id';

            if (Building::MEDICAL == $building) {
                $level = $team->baseMedical->base_medical_level + 1;
                $base = BaseMedical::find()->where(['base_medical_level' => $level]);
            } elseif (Building::PHYSICAL == $building) {
                $level = $team->basePhysical->base_physical_level + 1;
                $base = BasePhysical::find()->where(['base_physical_level' => $level]);
            } elseif (Building::SCHOOL == $building) {
                $level = $team->baseSchool->base_school_level + 1;
                $base = BaseSchool::find()->where(['base_school_level' => $level]);
            } elseif (Building::SCOUT == $building) {
                $level = $team->baseScout->base_scout_level + 1;
                $base = BaseScout::find()->where(['base_scout_level' => $level]);
            } elseif (Building::TRAINING == $building) {
                $level = $team->baseTraining->base_training_level + 1;
                $base = BaseTraining::find()->where(['base_training_level' => $level]);
            }
            $base = $base->limit(1)->one();

            if (!$base) {
                $this->setErrorFlash('Вы имеете здание максимального уровня.');
                return $this->redirect(['base-free/view']);
            } elseif ($base->$baseLevel > $team->base->base_level) {
                $this->setErrorFlash('Минимальный уровень базы должен быть не меньше <span class="strong">' . $base->$baseLevel . '</span>.');
                return $this->redirect(['base-free/view']);
            } elseif ($team->base->base_slot_max <= $team->baseUsed()) {
                $this->setErrorFlash('На базе нет свободных слотов для строительства.');
                return $this->redirect(['base-free/view']);
            } elseif (!$team->team_free_base) {
                $this->setErrorFlash('У вас нет бесплатных улучшений базы.');
                return $this->redirect(['base-free/view']);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    History::log([
                        'history_building_id' => $building,
                        'history_history_text_id' => HistoryText::BUILDING_UP,
                        'history_team_id' => $team->team_id,
                        'history_value' => $base->$baseLevel,
                    ]);

                    $team->$baseTeam++;
                    $team->team_free_base--;
                    $team->save(true, [$baseTeam, 'team_free_base']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство прошло успешно.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                    $this->setErrorFlash();
                }
                return $this->redirect(['base-free/view']);
            }

            $message = 'Строительство здания <span class="strong">'
                . $base->$baseLevel
                . '</span> уровня произойдет мгновенно.';
        }

        $this->setSeoTitle('Строительство базы команды ' . $team->fullName());

        return $this->render('build', [
            'building' => $building,
            'message' => $message,
            'team' => $team,
        ]);
    }
}
