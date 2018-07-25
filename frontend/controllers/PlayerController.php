<?php

namespace frontend\controllers;

use common\models\Lineup;

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
}
