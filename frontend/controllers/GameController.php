<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Event;
use common\models\Game;
use common\models\GameComment;
use common\models\GameVote;
use common\models\Lineup;
use common\models\UserRole;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class GameController
 * @package frontend\controllers
 */
class GameController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'delete-comment',
                    'vote',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'delete-comment',
                            'vote',
                        ],
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
    public function actionPreview($id)
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
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($game);

        if (!$game->game_played) {
            return $this->redirect(['game/preview', 'id' => $id]);
        }

        $model = new GameComment();
        if ($model->load(Yii::$app->request->post())) {
            $model->game_comment_game_id = $id;
            if ($model->save()) {
                $this->setSuccessFlash('Комментарий успешно сохранён');
                return $this->refresh();
            }
        }

        $lineupGuest = Lineup::find()
            ->with([
                'player',
                'player.name',
                'player.surname',
                'position',
            ])
            ->where([
                'lineup_game_id' => $id,
                'lineup_national_id' => $game->game_guest_national_id,
                'lineup_team_id' => $game->game_guest_team_id,
            ])
            ->orderBy(['lineup_line_id' => SORT_ASC, 'lineup_position_id' => SORT_ASC])
            ->all();

        $lineupHome = Lineup::find()
            ->with([
                'player',
                'player.name',
                'player.surname',
                'position',
            ])
            ->where([
                'lineup_game_id' => $id,
                'lineup_national_id' => $game->game_home_national_id,
                'lineup_team_id' => $game->game_home_team_id,
            ])
            ->orderBy(['lineup_line_id' => SORT_ASC, 'lineup_position_id' => SORT_ASC])
            ->all();

        $query = Event::find()
            ->with([
                'eventTextGoal',
                'eventTextPenalty',
                'eventTextShootout',
                'eventType',
                'national',
                'playerAssist1',
                'playerAssist1.name',
                'playerAssist1.surname',
                'playerAssist2',
                'playerAssist2.name',
                'playerAssist2.surname',
                'playerPenalty',
                'playerPenalty.name',
                'playerPenalty.surname',
                'playerScore',
                'playerScore.name',
                'playerScore.surname',
                'team',
            ])
            ->where(['event_game_id' => $id])
            ->orderBy(['event_id' => SORT_ASC]);

        $eventDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        $query = GameComment::find()
            ->with(['user'])
            ->where(['game_comment_game_id' => $id])
            ->orderBy(['game_comment_id' => SORT_ASC]);

        $commentDataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Матч');

        return $this->render('view', [
            'commentDataProvider' => $commentDataProvider,
            'eventDataProvider' => $eventDataProvider,
            'game' => $game,
            'lineupGuest' => $lineupGuest,
            'lineupHome' => $lineupHome,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @param int $gameId
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteComment($id, $gameId)
    {
        if (UserRole::ADMIN != $this->user->user_user_role_id) {
            $this->forbiddenRole();
        }

        $model = GameComment::find()
            ->where(['game_comment_id' => $id, 'game_comment_game_id' => $gameId])
            ->limit(1)
            ->one();
        $this->notFound($model);

        try {
            $model->delete();
            $this->setSuccessFlash('Комментарий успешно удалён.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['game/view', 'id' => $gameId]);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionVote($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id])
            ->andWhere(['!=', 'game_played', 0])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $vote = Yii::$app->request->get('vote', 1);
        if (!in_array($vote, [-1, 1])) {
            $vote = 1;
        }

        $model = GameVote::find()
            ->where(['game_vote_game_id' => $id, 'game_vote_user_id' => $this->user->user_id])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new GameVote();
            $model->game_vote_game_id = $id;
            $model->game_vote_user_id = $this->user->user_id;
        }
        $model->game_vote_rating = $vote;
        $model->save();

        return $this->redirect(['game/view', 'id' => $id]);
    }
}
