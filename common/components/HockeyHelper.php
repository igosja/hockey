<?php

namespace common\components;

use common\models\Game;
use common\models\National;
use common\models\Team;
use yii\helpers\Html;

/**
 * Class HockeyHelper
 * @package common\components
 */
class HockeyHelper
{
    public static function gameHomeGuest(Game $game, int $teamId): string
    {
        if ($game->game_home_team_id == $teamId) {
            $result = 'Д';
        } else {
            $result = 'Г';
        }
        return $result;
    }

    public static function gamePowerPercent(Game $game, int $teamId): string
    {
        if ($game->game_home_team_id == $teamId) {
            if ($game->game_played) {
                $result = self::powerPercent($game->game_guest_power / $game->game_home_power * 100);
            } else {
                $result = self::powerPercent($game->teamGuest->team_power_vs / $game->teamHome->team_power_vs * 100);
            }
        } else {
            if ($game->game_played) {
                $result = self::powerPercent($game->game_home_power / $game->game_guest_power * 100);
            } else {
                $result = self::powerPercent($game->teamHome->team_power_vs / $game->teamGuest->team_power_vs * 100);
            }
        }
        return $result;
    }

    /**
     * @param int $percent
     * @return string
     */
    public static function powerPercent(int $percent)
    {
        return ($percent ? round($percent) : 100) . '%';
    }

    /**
     * @param Game $game
     * @param int $teamId
     * @return string
     */
    public static function gamePlusMinus(Game $game, int $teamId): string
    {
        if ($game->game_played) {
            if ($game->game_home_team_id == $teamId) {
                $result = self::plusNecessary($game->game_home_plus_minus);
            } else {
                $result = self::plusNecessary($game->game_guest_plus_minus);
            }
        } else {
            $result = '';
        }
        return $result;
    }

    /**
     * @param int $value
     * @return string
     */
    public static function plusNecessary(int $value): string
    {
        if ($value > 0) {
            $result = '+' . $value;
        } else {
            $result = $value;
        }
        return $result;
    }

    /**
     * @param Game $game
     * @param int $teamId
     * @return string
     */
    public static function gameAuto(Game $game, int $teamId): string
    {
        if ($game->game_home_team_id == $teamId && $game->game_home_auto) {
            return 'А';
        } elseif ($game->game_guest_team_id == $teamId && $game->game_guest_auto) {
            return 'А';
        }
        return '';
    }

    /**
     * @param Game $game
     * @param int $teamId
     * @return string
     */
    public static function opponentLink(Game $game, int $teamId): string
    {
        if ($game->game_home_team_id == $teamId) {
            return Html::a(
                $game->teamGuest->team_name
                . ' <span class="hidden-xs">('
                . $game->teamGuest->stadium->city->city_name
                . ', '
                . $game->teamGuest->stadium->city->country->country_name
                . ')</span>',
                ['team/view', 'id' => $game->game_guest_team_id]
            );
        } else {
            return Html::a(
                $game->teamHome->team_name
                . ' <span class="hidden-xs">('
                . $game->teamHome->stadium->city->city_name
                . ', '
                . $game->teamHome->stadium->city->country->country_name
                . ')</span>',
                ['team/view', 'id' => $game->game_home_team_id]
            );
        }
    }

    /**
     * @param Game $game
     * @param int $teamId
     * @return string
     */
    public static function formatTeamScore(Game $game, int $teamId): string
    {
        if ($game->game_home_team_id == $teamId) {
            return self::formatScore($game, 'home');
        } else {
            return self::formatScore($game, 'guest');
        }
    }

    /**
     * @param Game $game
     * @param string $first
     * @return string
     */
    public static function formatScore(Game $game, $first = 'home'): string
    {
        if ($game->game_played) {
            if ('home' == $first) {
                return $game->game_home_score . ':' . $game->game_guest_score;
            } else {
                return $game->game_guest_score . ':' . $game->game_home_score;
            }
        } else {
            return '?:?';
        }
    }

    /**
     * @param Team $team
     * @param National $national
     * @param boolean $full
     * @param boolean $link
     * @return string
     */
    public static function teamOrNationalLink(
        Team $team = null,
        National $national = null,
        $full = true,
        $link = true
    ): string {
        if ($team) {
            $name = $team->team_name;

            if (true == $full) {
                $name = $name . ' ' . Html::tag(
                        'span',
                        '(' . $team->stadium->city->city_name . ', ' . $team->stadium->city->country->country_name . ')',
                        ['class' => 'hidden-xs']
                    );
            }

            if (true == $link) {
                return Html::a($name, ['team/view', 'id' => $team->team_id]);
            } else {
                return $name;
            }
        } elseif ($national) {
            $name = $national->country->country_name;

            if ($full) {
                $name = $name . ' ' . Html::tag(
                        'span',
                        '(' . $national->nationalType->national_type_name . ')',
                        ['class' => 'hidden-xs']
                    );
            }

            if (true == $link) {
                return Html::a($name, ['national/view', 'id' => $national->national_id]);
            } else {
                return $name;
            }
        }

        return '';
    }
}