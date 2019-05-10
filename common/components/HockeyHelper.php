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
    /**
     * @param Game $game
     * @param integer $teamOrNationalId
     * @return string
     */
    public static function gameHomeGuest($game, $teamOrNationalId)
    {
        if (in_array($teamOrNationalId, [$game->game_home_team_id, $game->game_home_national_id])) {
            $result = 'Д';
        } else {
            $result = 'Г';
        }
        return $result;
    }

    /**
     * @param Game $game
     * @param integer $teamOrNationalId
     * @return string
     */
    public static function gamePowerPercent($game, $teamOrNationalId)
    {
        if (in_array($teamOrNationalId, [$game->game_home_team_id, $game->game_home_national_id])) {
            if ($game->game_played) {
                $result = self::powerPercent($game->game_guest_power / ($game->game_home_power ?: 1) * 100);
            } else {
                $result = self::powerPercent($game->teamGuest->team_power_vs / ($game->teamHome->team_power_vs ?: 1) * 100);
            }
        } else {
            if ($game->game_played) {
                $result = self::powerPercent($game->game_home_power / ($game->game_guest_power ?: 1) * 100);
            } else {
                $result = self::powerPercent($game->teamHome->team_power_vs / ($game->teamGuest->team_power_vs ?: 1) * 100);
            }
        }
        return $result;
    }

    /**
     * @param integer $percent
     * @return string
     */
    public static function powerPercent($percent)
    {
        return ($percent ? round($percent) : 100) . '%';
    }

    /**
     * @param Game $game
     * @param integer $teamId
     * @return string
     */
    public static function gamePlusMinus($game, $teamId)
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
     * @param integer $value
     * @return string
     */
    public static function plusNecessary($value)
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
     * @param integer $teamOrNationalId
     * @return string
     */
    public static function gameAuto($game, $teamOrNationalId)
    {
        if (in_array($teamOrNationalId, [$game->game_home_team_id, $game->game_home_national_id]) && $game->game_home_auto) {
            return 'А';
        } elseif (in_array($teamOrNationalId, [$game->game_guest_team_id, $game->game_guest_national_id]) == $teamOrNationalId && $game->game_guest_auto) {
            return 'А';
        }
        return '';
    }

    /**
     * @param integer $auto
     * @return string
     */
    public static function formatAuto($auto)
    {
        if ($auto) {
            return '*';
        }
        return '';
    }

    /**
     * @param Game $game
     * @param integer $teamId
     * @return string
     */
    public static function opponentLink($game, $teamId)
    {
        if ($game->game_home_team_id) {
            if ($game->game_home_team_id == $teamId) {
                return $game->teamGuest->teamLink('img');
            } else {
                return $game->teamHome->teamLink('img');
            }
        } else {
            if ($game->game_home_national_id == $teamId) {
                return $game->nationalGuest->nationalLink(true);
            } else {
                return $game->nationalHome->nationalLink(true);
            }
        }
    }

    /**
     * @param Game $game
     * @param integer $teamOrNationalId
     * @return string
     */
    public static function formatTeamScore($game, $teamOrNationalId)
    {
        if (in_array($teamOrNationalId, [$game->game_home_team_id, $game->game_home_national_id])) {
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
    public static function formatScore($game, $first = 'home')
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
     * @param string $linkType
     * @return string
     */
    public static function teamOrNationalLink(
        Team $team = null,
        National $national = null,
        $full = true,
        $link = true,
        $linkType = 'string'
    ) {
        if ($team && $team->team_id) {
            $name = $team->team_name;

            if (true == $full) {
                $name = $name . ' ' . Html::tag(
                        'span',
                        '(' . $team->stadium->city->city_name . ', ' . $team->stadium->city->country->country_name . ')',
                        ['class' => 'hidden-xs']
                    );
            }

            if (true == $link) {
                if ('string' == $linkType) {
                    return Html::a($name, ['team/view', 'id' => $team->team_id]);
                } else {
                    return $team->teamLink($linkType);
                }
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

    /**
     * @param $text
     * @return mixed|string|string[]|null
     */
    public static function bbDecode($text)
    {
        $text = Html::encode($text);
        $text = str_replace(']?', ']', $text);
        $text = preg_replace('/\[link\=(.*?)\](.*?)\[\/link\]/s', '<a href="$1" target="_blank">$2</a>', $text);
        $text = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/s', '<a href="$1" target="_blank">$2</a>', $text);
        $text = preg_replace('/\[img\](.*?)\[\/img\]/i', '<img class="img-responsive" src="$1" alt="Image" />', $text);
        $text = str_replace('class="img-responsive" src="https://virtual-hockey.org/img/', 'src="https://virtual-hockey.org/img/', $text);
        $text = str_replace('class="img-responsive" src="https://www.virtual-hockey.org/img/', 'src="https://www,virtual-hockey.org/img/', $text);
        $text = str_replace('class="img-responsive" src="/img/', 'src="/img/', $text);
        $text = str_replace('[p]', '<p>', $text);
        $text = str_replace('[/p]', '</p>', $text);
        $text = str_replace('[table]', '<table class="table table-bordered table-hover">', $text);
        $text = str_replace('[/table]', '</table>', $text);
        $text = str_replace('[tr]', '<tr>', $text);
        $text = str_replace('[/tr]', '</tr>', $text);
        $text = str_replace('[th]', '<th>', $text);
        $text = str_replace('[/th]', '</th>', $text);
        $text = str_replace('[td]', '<td>', $text);
        $text = str_replace('[/td]', '</td>', $text);
        $text = str_replace('[ul]', '<ul>', $text);
        $text = str_replace('[/ul]', '</ul>', $text);
        $text = str_replace('[li]', '<li>', $text);
        $text = str_replace('[/li]', '</li>', $text);
        $text = str_replace('[list]', '<ul>', $text);
        $text = str_replace('[/list]', '</ul>', $text);
        $text = str_replace('[list=1]', '<ol>', $text);
        $text = str_replace('[/list]', '</ol>', $text);
        $text = str_replace('[*]', '<li>', $text);
        $text = str_replace('[/*]', '</li>', $text);
        $text = str_replace('[b]', '<strong>', $text);
        $text = str_replace('[/b]', '</strong>', $text);
        $text = str_replace('[i]', '<em>', $text);
        $text = str_replace('[/i]', '</em>', $text);
        $text = str_replace('[u]', '<ins>', $text);
        $text = str_replace('[/u]', '</ins>', $text);
        $text = str_replace('[s]', '<del>', $text);
        $text = str_replace('[/s]', '</del>', $text);
        $text = str_replace('[quote]', '<blockquote>', $text);
        $text = str_replace('[/quote]', '</blockquote>', $text);
        $text = str_replace('[code]', '<code>', $text);
        $text = str_replace('[/code]', '</code>', $text);
//        $text = str_replace(':)', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm01.png" />', $text);
//        $text = str_replace(':(', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm02.png" />', $text);
//        $text = str_replace(':D', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm03.png" />', $text);
//        $text = str_replace(';)', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm04.png" />', $text);
//        $text = str_replace(':boss:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm05.png" />', $text);
//        $text = str_replace(':applause:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm06.png" />', $text);
//        $text = str_replace(':surprise:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm07.png" />', $text);
//        $text = str_replace(':sick:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm08.png" />', $text);
//        $text = str_replace(':angry:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm09.png" />', $text);
        $text = nl2br($text);

        return $text;
    }

    /**
     * @param $text
     * @return mixed
     */
    public static function clearBbCodeBeforeSave($text)
    {
        $text = str_replace(']?', ']', $text);
        return $text;
    }
}
