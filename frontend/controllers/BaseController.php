<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Base;
use common\models\BaseMedical;
use common\models\BasePhysical;
use common\models\BaseSchool;
use common\models\BaseScout;
use common\models\BaseTraining;
use common\models\Building;
use common\models\BuildingBase;
use common\models\ConstructionType;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Team;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;

/**
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['build', 'destroy', 'cancel'],
                'rules' => [
                    [
                        'actions' => ['build', 'destroy', 'cancel'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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

        if ($this->myTeam && $this->myTeam->team_id == $id) {
            if ($team->buildingBase && Building::BASE == $team->buildingBase->building_base_building_id) {
                $linkBaseArray[] = Html::a(
                    'Отменить строительство',
                    ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                    ['class' => 'btn margin']
                );
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
                        ['base/build', 'building' => Building::BASE],
                        ['class' => 'btn margin']
                    );
                }
                if ($team->base->base_level > Building::MIN_LEVEL) {
                    $linkBaseArray[] = Html::a(
                        'Разрушить',
                        ['base/destroy', 'building' => Building::BASE],
                        ['class' => 'btn margin']
                    );
                }

                if ($team->buildingBase && Building::TRAINING == $team->buildingBase->building_base_building_id) {
                    $linkTrainingArray[] = Html::a(
                        'Отменить строительство',
                        ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                        ['class' => 'btn margin']
                    );

                    $delTraining = true;
                } else {
                    if ($team->baseTraining->base_training_level < Building::MAX_LEVEL) {
                        $linkTrainingArray[] = Html::a(
                            'Строить',
                            ['base/build', 'building' => Building::TRAINING],
                            ['class' => 'btn margin']
                        );
                    }
                    if ($team->baseTraining->base_training_level > Building::MIN_LEVEL) {
                        $linkTrainingArray[] = Html::a(
                            'Разрушить',
                            ['base/destroy', 'building' => Building::TRAINING]
                        );
                        $linkTrainingArray[] = Html::a(
                            'Тренировка',
                            ['training/index'],
                            ['class' => 'btn margin']
                        );
                    }
                }

                if ($team->buildingBase && Building::PHYSICAL == $team->buildingBase->building_base_building_id) {
                    $linkPhysicalArray[] = Html::a(
                        'Отменить строительство',
                        ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                        ['class' => 'btn margin']
                    );

                    $delPhysical = true;
                } else {
                    if ($team->basePhysical->base_physical_level < Building::MAX_LEVEL) {
                        $linkPhysicalArray[] = Html::a(
                            'Строить',
                            ['base/build', 'building' => Building::PHYSICAL],
                            ['class' => 'btn margin']
                        );
                    }
                    if ($team->basePhysical->base_physical_level > Building::MIN_LEVEL) {
                        $linkPhysicalArray[] = Html::a(
                            'Разрушить',
                            ['base/destroy', 'building' => Building::PHYSICAL],
                            ['class' => 'btn margin']
                        );
                        $linkPhysicalArray[] = Html::a(
                            'Форма',
                            ['physical/index'],
                            ['class' => 'btn margin']
                        );
                    }
                }

                if ($team->buildingBase && Building::SCHOOL == $team->buildingBase->building_base_building_id) {
                    $linkSchoolArray[] = Html::a(
                        'Отменить строительство',
                        ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                        ['class' => 'btn margin']
                    );

                    $delSchool = true;
                } else {
                    if ($team->baseSchool->base_school_level < Building::MAX_LEVEL) {
                        $linkSchoolArray[] = Html::a(
                            'Строить',
                            ['base/build', 'building' => Building::SCHOOL],
                            ['class' => 'btn margin']
                        );
                    }
                    if ($team->baseSchool->base_school_level > Building::MIN_LEVEL) {
                        $linkSchoolArray[] = Html::a(
                            'Разрушить',
                            ['base/destroy', 'building' => Building::SCHOOL],
                            ['class' => 'btn margin']
                        );
                        $linkSchoolArray[] = Html::a(
                            'Молодежь',
                            ['school/index'],
                            ['class' => 'btn margin']
                        );
                    }
                }

                if ($team->buildingBase && Building::SCOUT == $team->buildingBase->building_base_building_id) {
                    $linkScoutArray[] = Html::a(
                        'Отменить строительство',
                        ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                        ['class' => 'btn margin']
                    );

                    $delScout = true;
                } else {
                    if ($team->baseScout->base_scout_level < Building::MAX_LEVEL) {
                        $linkScoutArray[] = Html::a(
                            'Строить',
                            ['base/build', 'building' => Building::SCOUT],
                            ['class' => 'btn margin']
                        );
                    }
                    if ($team->baseScout->base_scout_level > Building::MIN_LEVEL) {
                        $linkScoutArray[] = Html::a(
                            'Разрушить',
                            ['base/destroy', 'building' => Building::SCOUT],
                            ['class' => 'btn margin']
                        );
                        $linkScoutArray[] = Html::a(
                            'Изучение',
                            ['scout/index'],
                            ['class' => 'btn margin']
                        );
                    }
                }

                if ($team->buildingBase && Building::MEDICAL == $team->buildingBase->building_base_building_id) {
                    $linkMedicalArray[] = Html::a(
                        'Отменить строительство',
                        ['base/cancel', 'id' => $team->buildingBase->building_base_id],
                        ['class' => 'btn margin']
                    );

                    $delMedical = true;
                } else {
                    if ($team->baseMedical->base_medical_level < Building::MAX_LEVEL) {
                        $linkMedicalArray[] = Html::a(
                            'Строить',
                            ['base/build', 'building' => Building::MEDICAL],
                            ['class' => 'btn margin']
                        );
                    }
                    if ($team->baseMedical->base_medical_level > Building::MIN_LEVEL) {
                        $linkMedicalArray[] = Html::a(
                            'Разрушить',
                            ['base/destroy', 'building' => Building::MEDICAL],
                            ['class' => 'btn margin']
                        );
                    }
                }
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
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionBuild(int $building)
    {
        $team = $this->myTeam;
        $this->notFound($team);

        if ($team->buildingBase) {
            $this->setErrorFlash('На базе уже идет строительство.');
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        if (Building::BASE == $building) {
            $level = $team->base->base_level + 1;
            $base = Base::find()
                ->where(['base_level' => $level])
                ->limit(1)
                ->one();
            if (!$base) {
                $this->setErrorFlash('Вы имеете здание максимального уровня.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($base->base_slot_min > $team->baseUsed()) {
                $this->setErrorFlash('Минимальное количество занятых слотов должно быть не меньше <span class="strong">' . $base->base_slot_min . '</span>.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($base->base_price_buy > $team->team_finance) {
                $this->setErrorFlash('Для строительства нужно <span class="strong">' . FormatHelper::asCurrency($base->base_price_buy) . '</span>.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new BuildingBase();
                    $model->building_base_building_id = $building;
                    $model->building_base_construction_type_id = ConstructionType::BUILD;
                    $model->building_base_day = $base->base_build_speed;
                    $model->building_base_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_building_id' => $building,
                        'finance_finance_text_id' => FinanceText::OUTCOME_BUILDING_BASE,
                        'finance_level' => $base->base_level,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$base->base_price_buy,
                        'finance_value_after' => $team->team_finance - $base->base_price_buy,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $base->base_price_buy;
                    $team->save(true, ['team_finance']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство успешно началось.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $message = 'Строительство базы <span class="strong">' . $base->base_level
                . '</span> уровня будет стоить <span class="strong">' . FormatHelper::asCurrency($base->base_price_buy)
                . '</span> и займет <span class="strong">' . $base->base_build_speed
                . '</span> дн.';
        } else {
            $base = Building::find()
                ->where(['building_id' => $building])
                ->one();

            if (!$base) {
                $this->setErrorFlash('Тип строения выбран неправильно.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::TRAINING == $building && $team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::SCHOOL == $building && $team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::SCOUT == $building && $team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $baseLevel = $base->building_name . '_base_level';
            $basePrice = $base->building_name . '_price_buy';
            $baseSpeed = $base->building_name . '_build_speed';

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
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($base->$baseLevel > $team->base->base_level) {
                $this->setErrorFlash('Минимальный уровень базы должен быть не меньше <span class="strong">' . $base->$baseLevel . '</span>.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->base->base_slot_max <= $team->baseUsed()) {
                $this->setErrorFlash('На базе нет свободных слотов для строительства.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($base->$basePrice > $team->team_finance) {
                $this->setErrorFlash('Для строительства нужно <span class="strong">' . FormatHelper::asCurrency($base->$basePrice) . '</span>.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new BuildingBase();
                    $model->building_base_building_id = $building;
                    $model->building_base_construction_type_id = ConstructionType::BUILD;
                    $model->building_base_day = $base->$baseSpeed;
                    $model->building_base_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_building_id' => $building,
                        'finance_finance_text_id' => FinanceText::OUTCOME_BUILDING_BASE,
                        'finance_level' => $base->$baseLevel,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$base->$basePrice,
                        'finance_value_after' => $team->team_finance - $base->$basePrice,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $base->$basePrice;
                    $team->save(true, ['team_finance']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство успешно началось.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                    $this->setErrorFlash();
                }
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $message = 'Строительство здания <span class="strong">' . $base->$baseLevel
                . '</span> уровня будет стоить <span class="strong">' . FormatHelper::asCurrency($base->$basePrice)
                . '</span> и займет <span class="strong">' . $base->$baseSpeed
                . '</span> дн.';
        }

        $this->setSeoTitle('Строительство базы команды ' . $team->fullName());

        return $this->render('build', [
            'building' => $building,
            'message' => $message,
            'team' => $team,
        ]);
    }

    /**
     * @param int $building
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionDestroy(int $building)
    {
        $team = $this->myTeam;
        $this->notFound($team);

        if ($team->buildingBase) {
            $this->setErrorFlash('На базе уже идет строительство.');
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        if (Building::BASE == $building) {
            $level = $team->base->base_level - 1;
            $base = Base::find()
                ->where(['base_level' => $level])
                ->limit(1)
                ->one();
            if (!$base) {
                $this->setErrorFlash('Вы имеете здание минимального уровня.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif ($base->base_slot_max < $team->baseUsed()) {
                $this->setErrorFlash('Максимальное количество занятых слотов должно быть не больше <span class="strong">' . $base->base_slot_max . '</span>.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new BuildingBase();
                    $model->building_base_building_id = $building;
                    $model->building_base_construction_type_id = ConstructionType::DESTROY;
                    $model->building_base_day = 1;
                    $model->building_base_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_building_id' => $building,
                        'finance_finance_text_id' => FinanceText::INCOME_BUILDING_BASE,
                        'finance_level' => $base->base_level,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => $team->base->base_price_sell,
                        'finance_value_after' => $team->team_finance + $team->base->base_price_sell,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance + $team->base->base_price_sell;
                    $team->save(true, ['team_finance']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство успешно началось.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $message = 'При строительстве базы <span class="strong">' . $base->base_level
                . '</span> уровня вы получите компенсацию <span class="strong">' . FormatHelper::asCurrency($team->base->base_price_sell)
                . '</span>. Это займет <span class="strong">1</span> день.';
        } else {
            $base = Building::find()
                ->where(['building_id' => $building])
                ->one();

            if (!$base) {
                $this->setErrorFlash('Тип строения выбран неправильно.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::TRAINING == $building && $team->isTraining()) {
                $this->setErrorFlash('В тренировочном центре тренируются игроки.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::SCHOOL == $building && $team->isSchool()) {
                $this->setErrorFlash('В спортшколе идет подготовка игрока.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            } elseif (Building::SCOUT == $building && $team->isScout()) {
                $this->setErrorFlash('В скаутцентре идет изучение игроков.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $baseLevel = $base->building_name . '_base_level';

            if (Building::MEDICAL == $building) {
                $level = $team->baseMedical->base_medical_level - 1;
                $price = $team->baseMedical->base_medical_price_sell;
                $base = BaseMedical::find()->where(['base_medical_level' => $level]);
            } elseif (Building::PHYSICAL == $building) {
                $level = $team->basePhysical->base_physical_level - 1;
                $price = $team->basePhysical->base_physical_price_sell;
                $base = BasePhysical::find()->where(['base_physical_level' => $level]);
            } elseif (Building::SCHOOL == $building) {
                $level = $team->baseSchool->base_school_level - 1;
                $price = $team->baseSchool->base_school_price_sell;
                $base = BaseSchool::find()->where(['base_school_level' => $level]);
            } elseif (Building::SCOUT == $building) {
                $level = $team->baseScout->base_scout_level - 1;
                $price = $team->baseScout->base_scout_price_sell;
                $base = BaseScout::find()->where(['base_scout_level' => $level]);
            } else {
                $level = $team->baseTraining->base_training_level - 1;
                $price = $team->baseTraining->base_training_price_sell;
                $base = BaseTraining::find()->where(['base_training_level' => $level]);
            }
            $base = $base->limit(1)->one();

            if (!$base) {
                $this->setErrorFlash('Вы имеете здание минимального уровня.');
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            if (Yii::$app->request->get('ok')) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new BuildingBase();
                    $model->building_base_building_id = $building;
                    $model->building_base_construction_type_id = ConstructionType::DESTROY;
                    $model->building_base_day = 1;
                    $model->building_base_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_building_id' => $building,
                        'finance_finance_text_id' => FinanceText::INCOME_BUILDING_BASE,
                        'finance_level' => $base->$baseLevel,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => $price,
                        'finance_value_after' => $team->team_finance + $price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance + $price;
                    $team->save(true, ['team_finance']);
                    $transaction->commit();

                    $this->setSuccessFlash('Строительство успешно началось.');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                    $this->setErrorFlash();
                }
                return $this->redirect(['base/view', 'id' => $team->team_id]);
            }

            $message = 'При строительстве здания <span class="strong">' . $base->$baseLevel
                . '</span> уровня вы получите компенсацию <span class="strong">' . FormatHelper::asCurrency($price)
                . '</span>. Это займет <span class="strong">1</span> день.';
        }

        $this->setSeoTitle('Разрушение базы команды ' . $team->fullName());

        return $this->render('destroy', [
            'building' => $building,
            'message' => $message,
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCancel($id)
    {
        $team = $this->myTeam;
        $this->notFound($team);

        $buildingBase = BuildingBase::find()
            ->where(['building_base_id' => $id, 'building_base_ready' => 0, 'building_base_team_id' => $team->team_id])
            ->limit(1)
            ->one();
        if (!$buildingBase) {
            $this->setErrorFlash('Строительство выбрано неправильно.');
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        $finance = Finance::find()
            ->where([
                'finance_finance_text_id' => [FinanceText::INCOME_BUILDING_BASE, FinanceText::OUTCOME_BUILDING_BASE],
                'finance_team_id' => $team->team_id,
            ])
            ->orderBy(['finance_id' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$finance) {
            $this->setErrorFlash('Строительство выбрано неправильно.');
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($finance->finance_value < 0) {
                    $buildingId = FinanceText::INCOME_BUILDING_BASE;
                    $level = $finance->finance_level + 1;
                } else {
                    $buildingId = FinanceText::OUTCOME_BUILDING_BASE;
                    $level = $finance->finance_level - 1;
                }

                $buildingBase->delete();

                Finance::log([
                    'finance_building_id' => $buildingId,
                    'finance_finance_text_id' => FinanceText::INCOME_BUILDING_BASE,
                    'finance_level' => $level,
                    'finance_team_id' => $team->team_id,
                    'finance_value' => $finance->finance_value,
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
            return $this->redirect(['base/view', 'id' => $team->team_id]);
        }

        $this->setSeoTitle('Отмена строительства базы команды ' . $team->fullName());

        return $this->render('cancel', [
            'id' => $id,
            'price' => -$finance->finance_value,
            'team' => $team,
        ]);
    }
}
