<?php

namespace common\models;

/**
 * Class UpdateUserRating
 * @package common\models
 *
 * @property int $user_rating_id
 * @property int $user_rating_auto
 * @property int $user_rating_collision_loose
 * @property int $user_rating_collision_win
 * @property int $user_rating_game
 * @property int $user_rating_loose
 * @property int $user_rating_loose_equal
 * @property int $user_rating_loose_overtime
 * @property int $user_rating_loose_overtime_equal
 * @property int $user_rating_loose_overtime_strong
 * @property int $user_rating_loose_overtime_weak
 * @property int $user_rating_loose_strong
 * @property int $user_rating_loose_super
 * @property int $user_rating_loose_weak
 * @property int $user_rating_rating
 * @property int $user_rating_season_id
 * @property int $user_rating_user_id
 * @property int $user_rating_vs_super
 * @property int $user_rating_vs_rest
 * @property int $user_rating_win
 * @property int $user_rating_win_equal
 * @property int $user_rating_win_overtime
 * @property int $user_rating_win_overtime_equal
 * @property int $user_rating_win_overtime_strong
 * @property int $user_rating_win_overtime_weak
 * @property int $user_rating_win_strong
 * @property int $user_rating_win_super
 * @property int $user_rating_win_weak
 */
class UserRating extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_rating}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'user_rating_id',
                    'user_rating_auto',
                    'user_rating_collision_loose',
                    'user_rating_collision_win',
                    'user_rating_game',
                    'user_rating_loose',
                    'user_rating_loose_equal',
                    'user_rating_loose_overtime',
                    'user_rating_loose_overtime_equal',
                    'user_rating_loose_overtime_strong',
                    'user_rating_loose_overtime_weak',
                    'user_rating_loose_strong',
                    'user_rating_loose_super',
                    'user_rating_loose_weak',
                    'user_rating_rating',
                    'user_rating_season_id',
                    'user_rating_user_id',
                    'user_rating_vs_super',
                    'user_rating_vs_rest',
                    'user_rating_win',
                    'user_rating_win_equal',
                    'user_rating_win_overtime',
                    'user_rating_win_overtime_equal',
                    'user_rating_win_overtime_strong',
                    'user_rating_win_overtime_weak',
                    'user_rating_win_strong',
                    'user_rating_win_super',
                    'user_rating_win_weak',
                ],
                'integer'
            ],
            [['user_rating_user_id'], 'required'],
        ];
    }
}
