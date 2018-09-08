<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class UserRating
 * @package common\models
 *
 * @property integer $user_rating_id
 * @property integer $user_rating_auto
 * @property integer $user_rating_collision_loose
 * @property integer $user_rating_collision_win
 * @property integer $user_rating_game
 * @property integer $user_rating_loose
 * @property integer $user_rating_loose_equal
 * @property integer $user_rating_loose_overtime
 * @property integer $user_rating_loose_overtime_equal
 * @property integer $user_rating_loose_overtime_strong
 * @property integer $user_rating_loose_overtime_weak
 * @property integer $user_rating_loose_strong
 * @property integer $user_rating_loose_super
 * @property integer $user_rating_loose_weak
 * @property integer $user_rating_rating
 * @property integer $user_rating_season_id
 * @property integer $user_rating_user_id
 * @property integer $user_rating_vs_super
 * @property integer $user_rating_vs_rest
 * @property integer $user_rating_win
 * @property integer $user_rating_win_equal
 * @property integer $user_rating_win_overtime
 * @property integer $user_rating_win_overtime_equal
 * @property integer $user_rating_win_overtime_strong
 * @property integer $user_rating_win_overtime_weak
 * @property integer $user_rating_win_strong
 * @property integer $user_rating_win_super
 * @property integer $user_rating_win_weak
 */
class UserRating extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_rating}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
