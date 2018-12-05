<?php

namespace frontend\controllers;

use common\models\Building;
use common\models\Team;
use yii\helpers\Html;

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

        $this->setSeoTitle('База команды');

        return $this->render('view', [
            'delBase' => $delBase,
            'delMedical' => $delMedical,
            'delPhysical' => $delPhysical,
            'delSchool' => $delSchool,
            'delScout' => $delScout,
            'delTraining' => $delTraining,
            'linkBaseArray' => implode(' ', $linkBaseArray),
            'linkMedicalArray' => implode(' ', $linkMedicalArray),
            'linkPhysicalArray' => implode(' ', $linkPhysicalArray),
            'linkSchoolArray' => implode(' ', $linkSchoolArray),
            'linkScoutArray' => implode(' ', $linkScoutArray),
            'linkTrainingArray' => implode(' ', $linkTrainingArray),
            'team' => $team,
        ]);
    }
}
