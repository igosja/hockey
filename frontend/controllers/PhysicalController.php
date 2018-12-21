<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Building;
use common\models\Physical;
use common\models\PhysicalChange;
use common\models\Player;
use common\models\Schedule;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class PhysicalController
 * @package frontend\controllers
 */
class PhysicalController extends AbstractController
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

        $physicalArray = ArrayHelper::map(Physical::find()->all(), 'physical_id', 'physical_name');

        $scheduleArray = Schedule::find()
            ->with(['stage', 'tournamentType'])
            ->where(['>', 'schedule_date', HockeyHelper::unixTimeStamp()])
            ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::CONFERENCE])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        $countSchedule = count($scheduleArray);

        $changeArray = [];
        $physicalChangeArray = PhysicalChange::find()
            ->where(['physical_change_team_id' => $team->team_id])
            ->all();
        foreach ($physicalChangeArray as $item) {
            $changeArray[$item->physical_change_player_id][$item->physical_change_schedule_id] = 1;
        }

        $query = Player::find()
            ->with(['playerPosition.position'])
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $playerArray = $query->all();

        $physicalId = 0;
        $playerPhysicalArray = [];

        for ($i = 0; $i < $query->count(); $i++) {
            $class = '';
            $currentPlayerPhysicalArray = [];

            for ($j = 0; $j < $countSchedule; $j++) {
                if (0 == $j) {
                    $physicalId = $playerArray[$i]->player_physical_id;
                } else {
                    $physicalId++;
                }

                if (20 < $physicalId) {
                    $physicalId = $physicalId - 20;
                }

                if (isset($changeArray[$playerArray[$i]->player_id][$scheduleArray[$j]->schedule_id])) {
                    $class = 'physical-change-cell physical-bordered';

                    $opposite = Physical::find()
                        ->where(['physical_id' => $physicalId])
                        ->limit(1)
                        ->one();
                    $physicalId = $opposite->physical_opposite;
                } elseif (in_array($class, array('physical-change-cell physical-bordered', 'physical-change-cell physical-yellow', 'physical-bordered'))) {
                    $class = ($this->isOnBuilding() ? '' : 'physical-change-cell') . ' physical-yellow';
                } else {
                    $class = ($this->isOnBuilding() ? '' : 'physical-change-cell');
                }

                $currentPlayerPhysicalArray[] = [
                    'class' => $class,
                    'id' => $playerArray[$i]->player_id . '-' . $scheduleArray[$j]->schedule_id,
                    'physical_id' => $physicalId,
                    'physical_name' => $physicalArray[$physicalId],
                    'player_id' => $playerArray[$i]->player_id,
                    'schedule_id' => $scheduleArray[$j]->schedule_id,
                ];
            }

            $playerPhysicalArray[$playerArray[$i]->player_id] = $currentPlayerPhysicalArray;
        }

        $playerId = [];

        foreach ($playerArray as $item) {
            $playerId[] = $item['player_id'];
        }

        $this->setSeoTitle($team->fullName() . '. Центр физической подготовки');

        return $this->render('index', [
            'countSchedule' => $countSchedule,
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'playerPhysicalArray' => $playerPhysicalArray,
            'scheduleArray' => $scheduleArray,
            'team' => $team,
        ]);
    }

    /**
     * @param string $tournament
     * @param string $stage
     * @param string $team
     */
    public function actionImage(string $tournament = null, string $stage = null, string $team = null)
    {
        if ($tournament && $stage) {
            $text = $tournament . ', ' . $stage;
        } elseif ($team) {
            $text = $team;
        } else {
            $text = '-';
        }

        header("Content-type: image/png");

        $image = imagecreate(20, 200);
//        $back_color = imagecolorallocate($image, 40, 96, 144);
        $text_color = imagecolorallocate($image, 255, 255, 255);

        //imagestringup($image, 3, 3, 81, iso2uni(convert_cyr_string($text ,"w","i")), $text_color);
        imagettftext($image, 11, 90, 15, 191, $text_color, Yii::getAlias('@webroot') . '/fonts/HelveticaNeue.ttf', $text);
        imagepng($image);
        imagedestroy($image);
    }

    /**
     * @return bool
     */
    private function isOnBuilding(): bool
    {
        if (!$this->myTeam->buildingBase) {
            return false;
        }

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::PHYSICAL])) {
            return false;
        }

        return true;
    }
}
