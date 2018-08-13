<?php

namespace frontend\controllers;

use common\models\AchievementPlayer;
use common\models\History;
use common\models\Lineup;
use common\models\Loan;
use common\models\Player;
use common\models\Squad;
use common\models\Transfer;
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
     * @param integer $id
     * @return string
     */
    public function actionEvent(int $id): string
    {
        $eventArray = History::find()
            ->select([
                'history_date',
                'history_history_text_id',
                'history_player_id',
                'history_season_id',
                'history_team_id',
            ])
            ->where(['history_player_id' => $id])
            ->orderBy(['history_id' => SORT_DESC])
            ->all();

        return $this->render('event', [
            'eventArray' => $eventArray,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionDeal(int $id): string
    {
        $loanArray = Loan::find()
            ->select([
            ])
            ->where(['loan_player_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC])
            ->all();

        $transferArray = Transfer::find()
            ->select([
            ])
            ->where(['transfer_player_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC])
            ->all();

        return $this->render('deal', [
            'loanArray' => $loanArray,
            'transferArray' => $transferArray,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionAchievement(int $id): string
    {
        $achievementArray = AchievementPlayer::find()
            ->select([
                'achievement_player_season_id',
                'achievement_player_stage_id',
                'achievement_player_team_id',
                'achievement_player_tournament_type_id',
            ])
            ->where(['achievement_player_player_id' => $id])
            ->orderBy(['achievement_player_id' => SORT_DESC])
            ->all();

        return $this->render('achievement', [
            'achievementArray' => $achievementArray,
        ]);
    }

    /**
     * @param integer $id
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSquad(int $id): bool
    {
        if (!$this->myTeam) {
            return false;
        }

        $player = Player::find()->where(['player_id' => $id, 'player_team_id' => $this->myTeam->team_id])->one();
        $this->notFound($player);

        $player->player_squad_id = Yii::$app->request->get('squad', Squad::SQUAD_DEFAULT);
        if (!$player->save()) {
            return false;
        }

        return true;
    }
}
