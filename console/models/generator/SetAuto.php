<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Mood;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;

/**
 * Class SetAuto
 * @package console\models\generator
 */
class SetAuto
{
    /**
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->indexBy('game_id')
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['or', ['game_guest_mood_id' => 0], ['game_home_mood_id' => 0]])
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            if (!$game->game_home_mood_id) {
                $game->game_home_auto = 1;
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
            }

            if (!$game->game_guest_mood_id) {
                $game->game_guest_auto = 1;
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
            }

            $game->save();
        }
    }
}