<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Building;
use common\models\Position;
use common\models\School;
use common\models\Season;
use common\models\Special;
use common\models\Style;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class SchoolController
 * @package frontend\controllers
 */
class SchoolController extends AbstractController
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

        $model = new \frontend\models\School();
        if ($model->load(Yii::$app->request->post(), '')) {
            return $this->redirect($model->redirectUrl());
        }

        $schoolArray = School::find()
            ->where(['school_ready' => 0, 'school_team_id' => $team->team_id])
            ->all();

        $this->setSeoTitle($team->fullName() . '. Спортивная школа');

        return $this->render('index', [
            'onBuilding' => $this->isOnBuilding(),
            'positionArray' => ArrayHelper::map(Position::find()->all(), 'position_id', 'position_name'),
            'schoolArray' => $schoolArray,
            'specialArray' => ArrayHelper::map(Special::find()->all(), 'special_id', 'special_text'),
            'styleArray' => ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name'),
            'team' => $team,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionStart()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($this->isOnBuilding()) {
            $this->setErrorFlash('На базе сейчас идет строительство.');
            return $this->redirect(['school/index']);
        }

        if (!$team->availableSchool()) {
            $this->setErrorFlash('У вас нет юниоров для подготовки в спортшколе.');
            return $this->redirect(['school/index']);
        }

        $school = School::find()
            ->where(['school_ready' => 0, 'school_team_id' => $team->team_id])
            ->count();
        if ($school) {
            $this->setErrorFlash('Нельзя готовить в спортшколе более одного игрока одновременно.');
            return $this->redirect(['school/index']);
        }

        $data = Yii::$app->request->get();

        $confirmData = [
            'position' => [],
            'special' => [],
            'style' => [],
        ];

        if (!$data['position_id']) {
            $this->setErrorFlash('Необходимо указать позицию игрока.');
            return $this->redirect(['school/index']);
        }

        $position = Position::find()
            ->where(['position_id' => $data['position_id']])
            ->limit(1)
            ->one();
        if (!$position) {
            $this->setErrorFlash('Позиция игрока выбрана неправильно.');
            return $this->redirect(['school/index']);
        }

        $confirmData['position'] = [
            'id' => $position->position_id,
            'name' => $position->position_name,
        ];

        if (Position::GK == $position->position_id) {
            $isGk = 1;
            $isField = null;
        } else {
            $isGk = null;
            $isField = 1;
        }

        if ($data['special_id'] && $team->availableSchoolWithSpecial()) {
            $specialId = $data['special_id'];
        } else {
            $specialId = null;
        }

        $special = Special::find()
            ->filterWhere(['special_gk' => $isGk, 'special_field' => $isField])
            ->andFilterWhere(['special_id' => $specialId])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$special) {
            $this->setErrorFlash('Спецвозможность игрока выбрана неправильно.');
            return $this->redirect(['school/index']);
        }

        $confirmData['special'] = [
            'id' => $special->special_id,
            'name' => $special->special_name,
            'with' => $specialId,
        ];

        if ($data['style_id'] && $team->availableSchoolWithStyle()) {
            $styleId = $data['style_id'];
        } else {
            $styleId = null;
        }

        $style = Style::find()
            ->andFilterWhere(['style_id' => $styleId])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$style) {
            $this->setErrorFlash('Стиль игрока выбран неправильно.');
            return $this->redirect(['school/index']);
        }

        $confirmData['style'] = [
            'id' => $style->style_id,
            'name' => $style->style_name,
            'with' => $styleId,
        ];

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new School();
                $model->school_day = $team->baseSchool->base_school_school_speed;
                $model->school_position_id = $position->position_id;
                $model->school_season_id = Season::getCurrentSeason();
                $model->school_special_id = $specialId;
                $model->school_style_id = $style->style_id;
                $model->school_team_id = $team->team_id;
                $model->school_with_special = $specialId ? 1 : 0;
                $model->school_with_special_request = $data['special_id'] ? 1 : 0;
                $model->school_with_style = $styleId ? 1 : 0;
                $model->school_with_style_request = $data['style_id'] ? 1 : 0;
                $model->save();
                $transaction->commit();

                $this->setSuccessFlash('Подготовка юниора успешно началась.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['school/index']);
        }

        $this->setSeoTitle($team->fullName() . '. Подготовка юниоров');

        return $this->render('start', [
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

        $school = School::find()
            ->where(['school_id' => $id, 'school_ready' => 0, 'school_team_id' => $team->team_id])
            ->limit(1)
            ->one();
        if (!$school) {
            $this->setErrorFlash('Игрок выбран неправильно.');
            return $this->redirect(['school/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $school->delete();

                $transaction->commit();

                $this->setSuccessFlash('Подготовка юниора успешно отменена.');
            } catch (Throwable $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['school/index']);
        }

        $this->setSeoTitle('Отмена поготовки юниора. ' . $team->fullName());

        return $this->render('cancel', [
            'id' => $id,
            'team' => $team,
            'school' => $school,
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

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::SCHOOL])) {
            return false;
        }

        return true;
    }
}
