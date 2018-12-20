<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Building;
use common\models\Player;
use common\models\Schedule;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

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

        $scheduleArray = Schedule::find()
            ->with(['stage', 'tournamentType'])
            ->where(['>', 'schedule_date', HockeyHelper::unixTimeStamp()])
            ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::CONFERENCE])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();

        $query = Player::find()
            ->with(['playerPosition.position'])
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Центр физической подготовки');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
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
        $back_color = imagecolorallocate($image, 40, 96, 144);
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
