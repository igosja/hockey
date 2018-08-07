<?php

namespace frontend\controllers;

use common\models\Lineup;
use common\models\Player;
use common\models\Squad;
use Yii;

/**
 * Class PlayerController
 * @package frontend\controllers
 */
class PlayerController extends BaseController
{
    /**
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $gameArray = Lineup::find()
            ->joinWith(['game.schedule'])
            ->where(['lineup_player_id' => $id])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->all();

        $this->view->title = 'Player profile';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Player profile - Virtual Hockey Online League'
        ]);

        return $this->render('view', [
            'gameArray' => $gameArray,
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function actionSquad(int $id)
    {
        if (!$this->myTeam) {
            return false;
        }
        $player = Player::find()->where(['player_id' => $id, 'player_team_id' => $this->myTeam->team_id])->one();
        if (!$player) {
            return false;
        }
        $player->player_squad_id = Yii::$app->request->get('squad', Squad::SQUAD_DEFAULT);
        if (!$player->save()) {
            return false;
        }
        return true;
    }
}
