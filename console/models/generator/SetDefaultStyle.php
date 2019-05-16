<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;

/**
 * Class SetDefaultStyle
 * @package console\models\generator
 */
class SetDefaultStyle
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'or',
                ['game_guest_rudeness_id_1' => 0],
                ['game_guest_rudeness_id_2' => 0],
                ['game_guest_rudeness_id_3' => 0],
                ['game_guest_rudeness_id_4' => 0],
                ['game_guest_style_id_1' => 0],
                ['game_guest_style_id_2' => 0],
                ['game_guest_style_id_3' => 0],
                ['game_guest_style_id_4' => 0],
                ['game_guest_tactic_id_1' => 0],
                ['game_guest_tactic_id_2' => 0],
                ['game_guest_tactic_id_3' => 0],
                ['game_guest_tactic_id_4' => 0],
                ['game_home_rudeness_id_1' => 0],
                ['game_home_rudeness_id_2' => 0],
                ['game_home_rudeness_id_3' => 0],
                ['game_home_rudeness_id_4' => 0],
                ['game_home_style_id_1' => 0],
                ['game_home_style_id_2' => 0],
                ['game_home_style_id_3' => 0],
                ['game_home_style_id_4' => 0],
                ['game_home_tactic_id_1' => 0],
                ['game_home_tactic_id_2' => 0],
                ['game_home_tactic_id_3' => 0],
                ['game_home_tactic_id_4' => 0],
            ])
            ->orderBy(['game_id' => SORT_ASC])
            ->each(5);
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            if (!$game->game_home_rudeness_id_1) {
                $game->game_home_rudeness_id_1 = Rudeness::NORMAL;
            }
            if (!$game->game_home_rudeness_id_2) {
                $game->game_home_rudeness_id_2 = Rudeness::NORMAL;
            }
            if (!$game->game_home_rudeness_id_3) {
                $game->game_home_rudeness_id_3 = Rudeness::NORMAL;
            }
            if (!$game->game_home_rudeness_id_4) {
                $game->game_home_rudeness_id_4 = Rudeness::NORMAL;
            }
            if (!$game->game_home_style_id_1) {
                $game->game_home_style_id_1 = Style::NORMAL;
            }
            if (!$game->game_home_style_id_2) {
                $game->game_home_style_id_2 = Style::NORMAL;
            }
            if (!$game->game_home_style_id_3) {
                $game->game_home_style_id_3 = Style::NORMAL;
            }
            if (!$game->game_home_style_id_4) {
                $game->game_home_style_id_4 = Style::NORMAL;
            }
            if (!$game->game_home_tactic_id_1) {
                $game->game_home_tactic_id_1 = Tactic::NORMAL;
            }
            if (!$game->game_home_tactic_id_2) {
                $game->game_home_tactic_id_2 = Tactic::NORMAL;
            }
            if (!$game->game_home_tactic_id_3) {
                $game->game_home_tactic_id_3 = Tactic::NORMAL;
            }
            if (!$game->game_home_tactic_id_4) {
                $game->game_home_tactic_id_4 = Tactic::NORMAL;
            }

            if (!$game->game_guest_rudeness_id_1) {
                $game->game_guest_rudeness_id_1 = Rudeness::NORMAL;
            }
            if (!$game->game_guest_rudeness_id_2) {
                $game->game_guest_rudeness_id_2 = Rudeness::NORMAL;
            }
            if (!$game->game_guest_rudeness_id_3) {
                $game->game_guest_rudeness_id_3 = Rudeness::NORMAL;
            }
            if (!$game->game_guest_rudeness_id_4) {
                $game->game_guest_rudeness_id_4 = Rudeness::NORMAL;
            }
            if (!$game->game_guest_style_id_1) {
                $game->game_guest_style_id_1 = Style::NORMAL;
            }
            if (!$game->game_guest_style_id_2) {
                $game->game_guest_style_id_2 = Style::NORMAL;
            }
            if (!$game->game_guest_style_id_3) {
                $game->game_guest_style_id_3 = Style::NORMAL;
            }
            if (!$game->game_guest_style_id_4) {
                $game->game_guest_style_id_4 = Style::NORMAL;
            }
            if (!$game->game_guest_tactic_id_1) {
                $game->game_guest_tactic_id_1 = Tactic::NORMAL;
            }
            if (!$game->game_guest_tactic_id_2) {
                $game->game_guest_tactic_id_2 = Tactic::NORMAL;
            }
            if (!$game->game_guest_tactic_id_3) {
                $game->game_guest_tactic_id_3 = Tactic::NORMAL;
            }
            if (!$game->game_guest_tactic_id_4) {
                $game->game_guest_tactic_id_4 = Tactic::NORMAL;
            }

            $game->save();
        }
    }
}
