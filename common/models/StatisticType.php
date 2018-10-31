<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class StatisticType
 * @package common\models
 *
 * @property int $statistic_type_id
 * @property string $statistic_type_name
 * @property string $statistic_type_select
 * @property int $statistic_type_sort
 * @property int $statistic_type_statistic_chapter_id
 */
class StatisticType extends ActiveRecord
{
    const PLAYER_ASSIST = 14;
    const PLAYER_ASSIST_POWER = 15;
    const PLAYER_ASSIST_SHORT = 16;
    const PLAYER_SHOOTOUT_WIN = 17;
    const PLAYER_FACE_OFF = 18;
    const PLAYER_FACE_OFF_PERCENT = 19;
    const PLAYER_FACE_OFF_WIN = 20;
    const PLAYER_GAME = 21;
    const PLAYER_LOOSE = 22;
    const PLAYER_PASS = 23;
    const PLAYER_PASS_PER_GAME = 24;
    const PLAYER_PENALTY = 25;
    const PLAYER_PLUS_MINUS = 26;
    const PLAYER_POINT = 27;
    const PLAYER_SAVE = 28;
    const PLAYER_SAVE_PERCENT = 29;
    const PLAYER_SCORE = 30;
    const PLAYER_SCORE_DRAW = 31;
    const PLAYER_SCORE_POWER = 32;
    const PLAYER_SCORE_SHORT = 33;
    const PLAYER_SCORE_SHOT_PERCENT = 34;
    const PLAYER_SCORE_WIN = 35;
    const PLAYER_SHOT = 36;
    const PLAYER_SHOT_GK = 37;
    const PLAYER_SHOT_PER_GAME = 38;
    const PLAYER_SHUTOUT = 39;
    const PLAYER_WIN = 40;
    const TEAM_NO_PASS = 1;
    const TEAM_NO_SCORE = 2;
    const TEAM_LOOSE = 3;
    const TEAM_LOOSE_SHOOTOUT = 4;
    const TEAM_LOOSE_OVER = 5;
    const TEAM_PASS = 6;
    const TEAM_SCORE = 7;
    const TEAM_PENALTY = 8;
    const TEAM_PENALTY_OPPONENT = 9;
    const TEAM_WIN = 10;
    const TEAM_WIN_SHOOTOUT = 11;
    const TEAM_WIN_OVER = 12;
    const TEAM_WIN_PERCENT = 13;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%statistic_type}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['statistic_type_id', 'statistic_type_statistic_chapter_id', 'statistic_type_sort'], 'integer'],
            [
                [
                    'statistic_type_name',
                    'statistic_type_statistic_chapter_id',
                    'statistic_type_select',
                    'statistic_type_sort'
                ],
                'required'
            ],
            [['statistic_type_name', 'statistic_type_select'], 'string', 'max' => 255],
            [['statistic_type_name', 'statistic_type_select'], 'trim'],
        ];
    }

    /**
     * @return bool
     */
    public function isTeamChapter(): bool
    {
        return in_array($this->statistic_type_id, [
            StatisticType::TEAM_NO_PASS,
            StatisticType::TEAM_NO_SCORE,
            StatisticType::TEAM_LOOSE,
            StatisticType::TEAM_LOOSE_SHOOTOUT,
            StatisticType::TEAM_LOOSE_OVER,
            StatisticType::TEAM_PASS,
            StatisticType::TEAM_SCORE,
            StatisticType::TEAM_PENALTY,
            StatisticType::TEAM_PENALTY_OPPONENT,
            StatisticType::TEAM_WIN,
            StatisticType::TEAM_WIN_SHOOTOUT,
            StatisticType::TEAM_WIN_OVER,
            StatisticType::TEAM_WIN_PERCENT,
        ]);
    }

    /**
     * @return bool
     */
    public function isGkType(): bool
    {
        return in_array($this->statistic_type_id, [
            StatisticType::PLAYER_PASS,
            StatisticType::PLAYER_PASS_PER_GAME,
            StatisticType::PLAYER_SAVE,
            StatisticType::PLAYER_SAVE_PERCENT,
            StatisticType::PLAYER_SHOT_GK,
        ]);
    }
}
