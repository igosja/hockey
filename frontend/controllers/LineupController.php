<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Game;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class LineupController
 * @package frontend\controllers
 */
class LineupController extends BaseController
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
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex(int $id): string
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Game::find()
                ->joinWith(['schedule'])
                ->where(['game_played' => 0])
                ->andWhere([
                    'or',
                    ['game_guest_team_id' => $this->myTeam->team_id],
                    ['game_home_team_id' => $this->myTeam->team_id]
                ])
                ->orderBy(['schedule_date' => SORT_ASC])
                ->limit(5),
        ]);

        $substitutionArray = [
            [
                ['line_id' => 1, 'position_id' => Position::GK],
                ['line_id' => 2, 'position_id' => Position::GK],
            ],
            [
                ['line_id' => 1, 'position_id' => Position::LD],
                ['line_id' => 1, 'position_id' => Position::RD],
                ['line_id' => 1, 'position_id' => Position::LW],
                ['line_id' => 1, 'position_id' => Position::CF],
                ['line_id' => 1, 'position_id' => Position::RW],
            ],
            [
                ['line_id' => 2, 'position_id' => Position::LD],
                ['line_id' => 2, 'position_id' => Position::RD],
                ['line_id' => 2, 'position_id' => Position::LW],
                ['line_id' => 2, 'position_id' => Position::CF],
                ['line_id' => 2, 'position_id' => Position::RW],
            ],
            [
                ['line_id' => 3, 'position_id' => Position::LD],
                ['line_id' => 3, 'position_id' => Position::RD],
                ['line_id' => 3, 'position_id' => Position::LW],
                ['line_id' => 3, 'position_id' => Position::CF],
                ['line_id' => 3, 'position_id' => Position::RW],
            ],
            [
                ['line_id' => 4, 'position_id' => Position::LD],
                ['line_id' => 4, 'position_id' => Position::RD],
                ['line_id' => 4, 'position_id' => Position::LW],
                ['line_id' => 4, 'position_id' => Position::CF],
                ['line_id' => 4, 'position_id' => Position::RW],
            ],
        ];

        $lineupArray = Lineup::find()
            ->where(['lineup_game_id' => $id, 'lineup_team_id' => $this->myTeam->team_id])
            ->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'game' => $game,
            'lineupArray' => $lineupArray,
            'substitutionArray' => $substitutionArray,
        ]);
    }

    /**
     * @param $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTactic($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        if (Yii::$app->request->isAjax && $game->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($game);
        }

        if ($game->load(Yii::$app->request->post())) {
            if ($game->save()) {
                Yii::$app->session->setFlash('success', 'Тактика успешно сохранена.');
                return $this->refresh();
            }
        }

        return $this->render('tactic', [
            'game' => $game,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSubstitution($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $positionId = (int)Yii::$app->request->get('position_id');

        $lineup = Lineup::find()
            ->where([
                'lineup_game_id' => $id,
                'lineup_team_id' => $this->myTeam->team_id,
                'lineup_line_id' => Yii::$app->request->get('line_id'),
                'lineup_position_id' => $positionId
            ])
            ->limit(1)
            ->one();

        if (Position::GK != $positionId) {
            $positionWhere = ['!=', 'player_position_id', $positionId];
        } else {
            $positionWhere = ['player_position_id' => $positionId];
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Player::find()
                ->where(['player_team_id' => $this->myTeam->team_id, 'player_loan_team_id' => 0])
                ->orWhere(['player_loan_team_id' => $this->myTeam->team_id])
                ->andWhere($positionWhere)
                ->andWhere([
                    'not',
                    ['player_id' => Lineup::find()->select(['lineup_player_id'])->where(['lineup_game_id' => $id])]
                ]),
        ]);

        return $this->render('substitution', [
            'dataProvider' => $dataProvider,
            'lineup' => $lineup,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChange($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $positionId = (int)Yii::$app->request->get('position_id');

        if (Position::GK != $positionId) {
            $positionWhere = ['!=', 'player_position_id', $positionId];
        } else {
            $positionWhere = ['player_position_id' => $positionId];
        }

        $player = Player::find()
            ->where([
                'player_team_id' => $this->myTeam->team_id,
                'player_loan_team_id' => 0,
                'player_id' => Yii::$app->request->get('player_id'),
            ])
            ->orWhere(['player_loan_team_id' => $this->myTeam->team_id])
            ->andWhere($positionWhere)
            ->limit(1)
            ->one();
        $this->notFound($player);

        $model = Lineup::find()
            ->where([
                'lineup_game_id' => $id,
                'lineup_line_id' => Yii::$app->request->get('line_id'),
                'lineup_position_id' => $positionId,
                'lineup_team_id' => $this->myTeam->team_id,
            ])
            ->one();
        if (!$model) {
            $model = new Lineup();
            $model->lineup_game_id = $id;
            $model->lineup_line_id = Yii::$app->request->get('line_id');
            $model->lineup_position_id = Yii::$app->request->get('position_id');
            $model->lineup_team_id = $this->myTeam->team_id;
        }
        $model->lineup_player_id = $player->player_id;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->save();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Игрок успешно добавлен в состав.');
        } catch (\Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
        }

        return $this->redirect(['lineup/index', 'id' => $id]);
    }
}
