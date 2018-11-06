<?php

namespace frontend\controllers;

use common\models\Game;
use yii\data\ActiveDataProvider;

/**
 * Class GameController
 * @package frontend\controllers
 */
class GameController extends AbstractController
{
    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPreview(int $id): string
    {
        $game = Game::find()
            ->where(['game_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $query = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'game_home_national_id' => $game->game_home_national_id,
                'game_home_team_id' => $game->game_home_team_id,
                'game_guest_national_id' => $game->game_guest_national_id,
                'game_guest_team_id' => $game->game_guest_team_id,
            ])
            ->orWhere([
                'game_home_national_id' => $game->game_guest_national_id,
                'game_home_team_id' => $game->game_guest_team_id,
                'game_guest_national_id' => $game->game_home_national_id,
                'game_guest_team_id' => $game->game_home_team_id,
            ])
            ->orderBy(['schedule_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Матч');

        return $this->render('preview', [
            'dataProvider' => $dataProvider,
            'game' => $game,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $game = Game::find()
            ->where(['game_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($game);

        if (!$game->game_played) {
            return $this->redirect(['game/preview', 'id' => $id]);
        }

        $query = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'game_home_national_id' => $game->game_home_national_id,
                'game_home_team_id' => $game->game_home_team_id,
                'game_guest_national_id' => $game->game_guest_national_id,
                'game_guest_team_id' => $game->game_guest_team_id,
            ])
            ->orWhere([
                'game_home_national_id' => $game->game_guest_national_id,
                'game_home_team_id' => $game->game_guest_team_id,
                'game_guest_national_id' => $game->game_home_national_id,
                'game_guest_team_id' => $game->game_home_team_id,
            ])
            ->orderBy(['schedule_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Матч');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'game' => $game
        ]);
    }
}
