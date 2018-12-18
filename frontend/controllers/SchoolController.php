<?php

namespace frontend\controllers;

use common\models\Building;
use common\models\Position;
use common\models\School;
use common\models\Special;
use common\models\Style;
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
