<?php

namespace common\components;

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
     * @param int $scoreHome
     * @param int $scoreGuest
     * @param int $played
     * @return string
     */
    public static function formatScore(int $scoreHome, int $scoreGuest, int $played): string
    {
        if ($played) {
            return $scoreHome . ':' . $scoreGuest;
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

    public static function getDateArrayByMonth($dateStart, $dateEnd)
    {
        $dateArray = [];

        while ($dateStart < $dateEnd) {
            $dateArray[] = date('M Y', $dateStart);
            $dateStart = strtotime('+1month', strtotime(date('Y-m-d', $dateStart)));
        }

        return $dateArray;
    }
}