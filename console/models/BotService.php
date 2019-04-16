<?php

namespace console\models;

use common\components\ErrorHelper;
use common\models\Bot;
use common\models\Game;
use common\models\Lineup;
use common\models\Mood;
use common\models\Player;
use common\models\Position;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use common\models\Team;
use common\models\TeamAsk;
use common\models\User;
use Exception;
use Throwable;
use Yii;
use yii\db\StaleObjectException;

/**
 * Class BotService
 * @package console\models\generator
 */
class BotService
{
    const COUNT_FREE_TEAM = 30;
    const BOT_LAST_VISIT = 5184000; //2 month

    /**
     * @throws StaleObjectException
     * @throws Throwable
     * @throws \yii\db\Exception
     */
    public function execute()
    {
        $this->deleteOldBot();
        $this->deleteExtraBot();
        $this->addNewBot();
        $this->lineup();
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    private function deleteOldBot()
    {
        $botArray = Bot::find()
            ->each();
        foreach ($botArray as $bot) {
            /**
             * @var Bot $bot
             */
            if ($bot->bot_date != $bot->user->user_date_login) {
                $bot->delete();
            }
        }
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     * @throws \yii\db\Exception
     */
    private function deleteExtraBot()
    {
        $countFreeTeam = Team::find()
            ->where(['team_user_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->count();
        if ($countFreeTeam >= self::COUNT_FREE_TEAM) {
            return;
        }

        $botArray = Bot::find()
            ->orderBy(['bot_date' => SORT_ASC])
            ->limit($countFreeTeam - self::COUNT_FREE_TEAM)
            ->all();
        foreach ($botArray as $bot) {
            foreach ($bot->user->team as $team) {
                $team->managerFire();
            }
            $bot->delete();
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    private function addNewBot()
    {
        $countFreeTeam = Team::find()
            ->where(['team_user_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->count();
        if ($countFreeTeam <= self::COUNT_FREE_TEAM) {
            return;
        }

        $user = User::find()
            ->where(['user_date_delete' => 0, 'user_holiday' => 0])
            ->andWhere(['<', 'user_date_login', time() - self::BOT_LAST_VISIT])
            ->andWhere(['not', ['user_id' => Bot::find()->select(['bot_user_id'])]])
            ->andWhere(['!=', 'user_id', 0])
            ->andWhere(['<', 'user_date_vip', time()])
            ->orderBy(['user_date_login' => SORT_ASC])
            ->limit(1)
            ->one();
        if (!$user) {
            return;
        }

        $team = Team::find()
            ->where(['team_user_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$team) {
            return;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $time = time();

            $model = new Bot();
            $model->bot_date = $time;
            $model->bot_user_id = $user->user_id;
            $model->save();

            $user->user_date_login = $time;
            $user->save(true, ['user_date_login']);

            $model = new TeamAsk();
            $model->team_ask_team_id = $team->team_id;
            $model->team_ask_user_id = $user->user_id;
            $model->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
        }
    }

    /**
     * @throws Exception
     */
    private function lineup()
    {
        $botArray = Bot::find()
            ->orderBy(['bot_date' => SORT_ASC])
            ->limit(20)
            ->all();
        foreach ($botArray as $bot) {
            $time = rand(time() - 30 * 60, time());

            $bot->bot_date = $time;
            $bot->save(true, ['bot_date']);

            $bot->user->user_date_login = $time;
            $bot->user->save(true, ['user_date_login']);

            $teamArray = Team::find()
                ->where(['team_user_id' => $bot->bot_user_id])
                ->orderBy(['team_id' => SORT_ASC])
                ->all();
            foreach ($teamArray as $team) {
                $game = Game::find()
                    ->joinWith(['schedule'], false)
                    ->where(['game_played' => 0])
                    ->andWhere([
                        'or',
                        ['game_guest_team_id' => $team->team_id],
                        ['game_home_team_id' => $team->team_id],
                    ])
                    ->orderBy(['schedule_date' => SORT_ASC])
                    ->limit(1)
                    ->one();
                if (!$game) {
                    continue;
                }

                if ($game->game_home_team_id == $team->team_id && $game->game_home_mood_id) {
                    continue;
                }

                if ($game->game_guest_team_id == $team->team_id && $game->game_guest_mood_id) {
                    continue;
                }

                if ($game->game_home_team_id == $team->team_id) {
                    $game->game_home_mood_id = Mood::NORMAL;
                    $game->game_home_rudeness_id_1 = Rudeness::NORMAL;
                    $game->game_home_rudeness_id_2 = Rudeness::NORMAL;
                    $game->game_home_rudeness_id_3 = Rudeness::NORMAL;
                    $game->game_home_rudeness_id_4 = Rudeness::NORMAL;
                    $game->game_home_style_id_1 = Style::NORMAL;
                    $game->game_home_style_id_2 = Style::NORMAL;
                    $game->game_home_style_id_3 = Style::NORMAL;
                    $game->game_home_style_id_4 = Style::NORMAL;
                    $game->game_home_tactic_id_1 = Tactic::NORMAL;
                    $game->game_home_tactic_id_2 = Tactic::NORMAL;
                    $game->game_home_tactic_id_3 = Tactic::NORMAL;
                    $game->game_home_tactic_id_4 = Tactic::NORMAL;
                    $game->game_home_user_id = $bot->bot_user_id;
                } else {
                    $game->game_guest_mood_id = Mood::NORMAL;
                    $game->game_guest_rudeness_id_1 = Rudeness::NORMAL;
                    $game->game_guest_rudeness_id_2 = Rudeness::NORMAL;
                    $game->game_guest_rudeness_id_3 = Rudeness::NORMAL;
                    $game->game_guest_rudeness_id_4 = Rudeness::NORMAL;
                    $game->game_guest_style_id_1 = Style::NORMAL;
                    $game->game_guest_style_id_2 = Style::NORMAL;
                    $game->game_guest_style_id_3 = Style::NORMAL;
                    $game->game_guest_style_id_4 = Style::NORMAL;
                    $game->game_guest_tactic_id_1 = Tactic::NORMAL;
                    $game->game_guest_tactic_id_2 = Tactic::NORMAL;
                    $game->game_guest_tactic_id_3 = Tactic::NORMAL;
                    $game->game_guest_tactic_id_4 = Tactic::NORMAL;
                    $game->game_guest_user_id = $bot->bot_user_id;
                }
                $game->save();

                Lineup::deleteAll(['lineup_game_id' => $game->game_id, 'lineup_team_id' => $team->team_id]);

                $playerArray = Player::find()
                    ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->orderBy(['player_tire' => SORT_ASC])
                    ->all();

                for ($j = 0; $j < Lineup::GAME_QUANTITY; $j++) {
                    if (in_array($j, [0])) {
                        $lineId = 0;
                    } elseif (in_array($j, [1, 2, 3, 4, 5, 6])) {
                        $lineId = 1;
                    } elseif (in_array($j, [7, 8, 9, 10, 11])) {
                        $lineId = 2;
                    } elseif (in_array($j, [12, 13, 14, 15, 16])) {
                        $lineId = 3;
                    } else {
                        $lineId = 4;
                    }

                    if (in_array($j, [0, 1])) {
                        $positionId = Position::GK;
                    } elseif (in_array($j, [2, 7, 12, 17])) {
                        $positionId = Position::LD;
                    } elseif (in_array($j, [3, 8, 13, 18])) {
                        $positionId = Position::RD;
                    } elseif (in_array($j, [4, 9, 14, 19])) {
                        $positionId = Position::LW;
                    } elseif (in_array($j, [5, 10, 15, 20])) {
                        $positionId = Position::CF;
                    } else {
                        $positionId = Position::RW;
                    }

                    $player = null;
                    foreach ($playerArray as $key => $playerItem) {
                        if (!$player && $playerItem->player_position_id == $positionId) {
                            $player = $playerItem;
                            unset($playerArray[$key]);
                        }
                    }

                    if (!$player) {
                        continue;
                    }

                    $lineup = new Lineup();
                    $lineup->lineup_line_id = $lineId;
                    $lineup->lineup_position_id = $positionId;
                    $lineup->lineup_team_id = $team->team_id;
                    $lineup->lineup_game_id = $game->game_id;
                    $lineup->lineup_player_id = $player->player_id;
                    $lineup->save(false, [
                        'lineup_line_id',
                        'lineup_position_id',
                        'lineup_team_id',
                        'lineup_game_id',
                        'lineup_player_id',
                    ]);
                }
            }
        }
    }
}