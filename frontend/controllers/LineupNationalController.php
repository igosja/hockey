<?php

namespace frontend\controllers;

use common\models\Game;
use common\models\LineupTemplate;
use common\models\Mood;
use common\models\Player;
use common\models\Position;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use common\models\TournamentType;
use Exception;
use frontend\models\GameNationalSend;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class LineupNationalController
 * @package frontend\controllers
 */
class LineupNationalController extends LineupController
{
    /**
     * @return array
     */
    public function behaviors()
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
     * @throws Exception
     */
    public function actionView($id)
    {
        if (!$this->myNationalOrVice) {
            return $this->redirect(['national/view']);
        }

        $game = $this->getGame($id);

        $model = new GameNationalSend(['game' => $game, 'national' => $this->myNationalOrVice]);
        if ($model->saveLineup()) {
            $this->setSuccessFlash('Состав успешно отправлен.');
            return $this->refresh();
        }

        $query = Game::find()
            ->joinWith(['schedule'])
            ->with([
                'schedule.stage',
                'schedule.tournamentType',
                'nationalGuest.stadium.city',
                'nationalHome.stadium.city',
            ])
            ->where(['game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
                ['game_home_national_id' => $this->myNationalOrVice->national_id]
            ])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(5);
        $gameDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Player::find()
            ->with([
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id]);
        $playerDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => ['player_physical_id' => SORT_ASC],
                        'desc' => ['player_physical_id' => SORT_DESC],
                    ],
                    'power_nominal' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => ['player_power_real' => SORT_ASC],
                        'desc' => ['player_power_real' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_national_squad_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_national_squad_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                    'tire' => [
                        'asc' => ['player_tire' => SORT_ASC],
                        'desc' => ['player_tire' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $playerArray = Player::find()
            ->with([
                'playerPosition.position',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id])
            ->andWhere(['player_position_id' => Position::GK])
            ->orderBy(['player_power_real' => SORT_DESC])
            ->all();
        $gkArray = [];
        foreach ($playerArray as $player) {
            if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
                $player->player_power_real = round($player->player_power_nominal * 0.75);
            }

            $gkArray[] = $player;
        }

        $ldArray = [];
        $rdArray = [];
        $lwArray = [];
        $cfArray = [];
        $rwArray = [];
        $playerArray = Player::find()
            ->with([
                'playerPosition.position',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_real' => SORT_DESC])
            ->all();
        foreach ($playerArray as $player) {
            $ldPlayer = clone $player;
            $rdPlayer = clone $player;
            $lwPlayer = clone $player;
            $cfPlayer = clone $player;
            $rwPlayer = clone $player;
            $ldCoefficient = 0;
            $rdCoefficient = 0;
            $lwCoefficient = 0;
            $cfCoefficient = 0;
            $rwCoefficient = 0;
            foreach ($player->playerPosition as $playerPosition) {
                if (Position::LD == $playerPosition->player_position_position_id) {
                    if (1 > $ldCoefficient) {
                        $ldCoefficient = 1;
                    }
                    if (0.9 > $rdCoefficient) {
                        $rdCoefficient = 0.9;
                    }
                    if (0.9 > $lwCoefficient) {
                        $lwCoefficient = 0.9;
                    }
                    if (0.8 > $cfCoefficient) {
                        $cfCoefficient = 0.8;
                    }
                    if (0.8 > $rwCoefficient) {
                        $rwCoefficient = 0.8;
                    }
                }
                if (Position::RD == $playerPosition->player_position_position_id) {
                    if (0.9 > $ldCoefficient) {
                        $ldCoefficient = 0.9;
                    }
                    if (1 > $rdCoefficient) {
                        $rdCoefficient = 1;
                    }
                    if (0.8 > $lwCoefficient) {
                        $lwCoefficient = 0.8;
                    }
                    if (0.8 > $cfCoefficient) {
                        $cfCoefficient = 0.8;
                    }
                    if (0.9 > $rwCoefficient) {
                        $rwCoefficient = 0.9;
                    }
                }
                if (Position::LW == $playerPosition->player_position_position_id) {
                    if (0.9 > $ldCoefficient) {
                        $ldCoefficient = 0.9;
                    }
                    if (0.8 > $rdCoefficient) {
                        $rdCoefficient = 0.8;
                    }
                    if (1 > $lwCoefficient) {
                        $lwCoefficient = 1;
                    }
                    if (0.9 > $cfCoefficient) {
                        $cfCoefficient = 0.9;
                    }
                    if (0.8 > $rwCoefficient) {
                        $rwCoefficient = 0.8;
                    }
                }
                if (Position::CF == $playerPosition->player_position_position_id) {
                    if (0.8 > $ldCoefficient) {
                        $ldCoefficient = 0.8;
                    }
                    if (0.8 > $rdCoefficient) {
                        $rdCoefficient = 0.8;
                    }
                    if (0.9 > $lwCoefficient) {
                        $lwCoefficient = 0.9;
                    }
                    if (1 > $cfCoefficient) {
                        $cfCoefficient = 1;
                    }
                    if (0.9 > $rwCoefficient) {
                        $rwCoefficient = 0.9;
                    }
                }
                if (Position::RW == $playerPosition->player_position_position_id) {
                    if (0.8 > $ldCoefficient) {
                        $ldCoefficient = 0.8;
                    }
                    if (0.9 > $rdCoefficient) {
                        $rdCoefficient = 0.9;
                    }
                    if (0.8 > $lwCoefficient) {
                        $lwCoefficient = 0.8;
                    }
                    if (0.9 > $cfCoefficient) {
                        $cfCoefficient = 0.9;
                    }
                    if (1 > $rwCoefficient) {
                        $rwCoefficient = 1;
                    }
                }
            }

            if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
                $ldPlayer->player_power_real = round($ldPlayer->player_power_nominal * $ldCoefficient * 0.75);
                $rdPlayer->player_power_real = round($rdPlayer->player_power_nominal * $rdCoefficient * 0.75);
                $lwPlayer->player_power_real = round($lwPlayer->player_power_nominal * $lwCoefficient * 0.75);
                $cfPlayer->player_power_real = round($cfPlayer->player_power_nominal * $cfCoefficient * 0.75);
                $rwPlayer->player_power_real = round($rwPlayer->player_power_nominal * $rwCoefficient * 0.75);
            } else {
                $ldPlayer->player_power_real = round($ldPlayer->player_power_real * $ldCoefficient);
                $rdPlayer->player_power_real = round($rdPlayer->player_power_real * $rdCoefficient);
                $lwPlayer->player_power_real = round($lwPlayer->player_power_real * $lwCoefficient);
                $cfPlayer->player_power_real = round($cfPlayer->player_power_real * $cfCoefficient);
                $rwPlayer->player_power_real = round($rwPlayer->player_power_real * $rwCoefficient);
            }

            $ldArray[] = $ldPlayer;
            $rdArray[] = $rdPlayer;
            $lwArray[] = $lwPlayer;
            $cfArray[] = $cfPlayer;
            $rwArray[] = $rwPlayer;
        }

        usort($gkArray, [$this, 'sortLineup']);
        usort($ldArray, [$this, 'sortLineup']);
        usort($rdArray, [$this, 'sortLineup']);
        usort($lwArray, [$this, 'sortLineup']);
        usort($cfArray, [$this, 'sortLineup']);
        usort($rwArray, [$this, 'sortLineup']);

        $gk_1_id = isset($model->line[0][0]) ? $model->line[0][0] : 0;
        $gk_2_id = isset($model->line[1][0]) ? $model->line[1][0] : 0;
        $ld_1_id = isset($model->line[1][1]) ? $model->line[1][1] : 0;
        $rd_1_id = isset($model->line[1][2]) ? $model->line[1][2] : 0;
        $lw_1_id = isset($model->line[1][3]) ? $model->line[1][3] : 0;
        $cf_1_id = isset($model->line[1][4]) ? $model->line[1][4] : 0;
        $rw_1_id = isset($model->line[1][5]) ? $model->line[1][5] : 0;
        $ld_2_id = isset($model->line[2][1]) ? $model->line[2][1] : 0;
        $rd_2_id = isset($model->line[2][2]) ? $model->line[2][2] : 0;
        $lw_2_id = isset($model->line[2][3]) ? $model->line[2][3] : 0;
        $cf_2_id = isset($model->line[2][4]) ? $model->line[2][4] : 0;
        $rw_2_id = isset($model->line[2][5]) ? $model->line[2][5] : 0;
        $ld_3_id = isset($model->line[3][1]) ? $model->line[3][1] : 0;
        $rd_3_id = isset($model->line[3][2]) ? $model->line[3][2] : 0;
        $lw_3_id = isset($model->line[3][3]) ? $model->line[3][3] : 0;
        $cf_3_id = isset($model->line[3][4]) ? $model->line[3][4] : 0;
        $rw_3_id = isset($model->line[3][5]) ? $model->line[3][5] : 0;
        $ld_4_id = isset($model->line[4][1]) ? $model->line[4][1] : 0;
        $rd_4_id = isset($model->line[4][2]) ? $model->line[4][2] : 0;
        $lw_4_id = isset($model->line[4][3]) ? $model->line[4][3] : 0;
        $cf_4_id = isset($model->line[4][4]) ? $model->line[4][4] : 0;
        $rw_4_id = isset($model->line[4][5]) ? $model->line[4][5] : 0;

        $noRest = null;
        $noSuper = null;
        if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
            $noSuper = Mood::SUPER;
            $noRest = Mood::REST;
        } elseif ($this->myNationalOrVice->national_mood_rest <= 0) {
            $noRest = Mood::REST;
        } elseif ($this->myNationalOrVice->national_mood_super <= 0) {
            $noSuper = Mood::SUPER;
        }
        $moodArray = Mood::find()
            ->andFilterWhere(['!=', 'mood_id', $noSuper])
            ->andFilterWhere(['!=', 'mood_id', $noRest])
            ->orderBy(['mood_id' => SORT_ASC])
            ->all();
        $moodArray = ArrayHelper::map($moodArray, 'mood_id', 'mood_name');

        foreach ($moodArray as $moodId => $moodName) {
            if (Mood::SUPER == $moodId) {
                $moodArray[$moodId] = $moodName . ' (' . $this->myNationalOrVice->national_mood_super . ')';
            } elseif (Mood::REST == $moodId) {
                $moodArray[$moodId] = $moodName . ' (' . $this->myNationalOrVice->national_mood_rest . ')';
            }
        }

        $this->setSeoTitle('Отправка состава');

        return $this->render('view', [
            'gk_1_id' => $gk_1_id,
            'gk_2_id' => $gk_2_id,
            'ld_1_id' => $ld_1_id,
            'rd_1_id' => $rd_1_id,
            'lw_1_id' => $lw_1_id,
            'cf_1_id' => $cf_1_id,
            'rw_1_id' => $rw_1_id,
            'ld_2_id' => $ld_2_id,
            'rd_2_id' => $rd_2_id,
            'lw_2_id' => $lw_2_id,
            'cf_2_id' => $cf_2_id,
            'rw_2_id' => $rw_2_id,
            'ld_3_id' => $ld_3_id,
            'rd_3_id' => $rd_3_id,
            'lw_3_id' => $lw_3_id,
            'cf_3_id' => $cf_3_id,
            'rw_3_id' => $rw_3_id,
            'ld_4_id' => $ld_4_id,
            'rd_4_id' => $rd_4_id,
            'lw_4_id' => $lw_4_id,
            'cf_4_id' => $cf_4_id,
            'rw_4_id' => $rw_4_id,
            'cfArray' => $cfArray,
            'game' => $game,
            'gameDataProvider' => $gameDataProvider,
            'gkArray' => $gkArray,
            'ldArray' => $ldArray,
            'lwArray' => $lwArray,
            'model' => $model,
            'moodArray' => $moodArray,
            'isVip' => $this->user->isVip(),
            'playerDataProvider' => $playerDataProvider,
            'rdArray' => $rdArray,
            'rudenessArray' => ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name'),
            'rwArray' => $rwArray,
            'styleArray' => ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name'),
            'tacticArray' => ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name'),
            'national' => $this->myNationalOrVice,
        ]);
    }

    /**
     * @param int $id
     * @return Game
     * @throws NotFoundHttpException
     */
    public function getGame($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
                ['game_home_national_id' => $this->myNationalOrVice->national_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        return $game;
    }

    /**
     * @return string
     */
    public function actionTemplate()
    {
        if (!$this->user->isVip()) {
            return '';
        }
        $lineupTemplateArray = LineupTemplate::find()
            ->where(['lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->orderBy(['lineup_template_name' => SORT_ASC])
            ->all();
        return $this->renderPartial('_template_table', [
            'lineupTemplateArray' => $lineupTemplateArray,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionTemplateSave()
    {
        if (!$this->user->isVip()) {
            return;
        }
        $model = new GameNationalSend();
        $model->saveLineupTemplate();
    }

    /**
     * @param $id
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionTemplateDelete($id)
    {
        if (!$this->user->isVip()) {
            return;
        }
        $model = LineupTemplate::find()
            ->where(['lineup_template_id' => $id, 'lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
    }

    /**
     * @param $id
     * @return array|LineupTemplate|ActiveRecord|null
     */
    public function actionTemplateLoad($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = LineupTemplate::find()
            ->where(['lineup_template_id' => $id, 'lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->limit(1)
            ->one();
        if (!$model) {
            return (new LineupTemplate())->attributes;
        }
        return $model->attributes;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return GameNationalSend::class;
    }
}
