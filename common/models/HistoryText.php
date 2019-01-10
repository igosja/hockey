<?php

namespace common\models;

/**
 * Class HistoryText
 * @package common\models
 *
 * @property int $history_text_id
 * @property string $history_text_text
 */
class HistoryText extends AbstractActiveRecord
{
    const BUILDING_DOWN = 16;
    const BUILDING_UP = 15;
    const CHANGE_SPECIAL = 20;
    const CHANGE_STYLE = 19;
    const PLAYER_BONUS_POINT = 35;
    const PLAYER_BONUS_POSITION = 36;
    const PLAYER_BONUS_SPECIAL = 37;
    const PLAYER_CHAMPIONSHIP_SPECIAL = 34;
    const PLAYER_EXCHANGE = 40;
    const PLAYER_FREE = 43;
    const PLAYER_FROM_SCHOOL = 26;
    const PLAYER_GAME_POINT_MINUS = 33;
    const PLAYER_GAME_POINT_PLUS = 32;
    const PLAYER_INJURY = 38;
    const PLAYER_LOAN = 41;
    const PLAYER_LOAN_BACK = 42;
    const PLAYER_PENSION_GO = 28;
    const PLAYER_PENSION_SAY = 27;
    const PLAYER_TRAINING_POINT = 29;
    const PLAYER_TRAINING_POSITION = 30;
    const PLAYER_TRAINING_SPECIAL = 31;
    const PLAYER_TRANSFER = 39;
    const STADIUM_DOWN = 18;
    const STADIUM_UP = 17;
    const TEAM_REGISTER = 1;
    const TEAM_RE_REGISTER = 2;
    const USER_MANAGER_NATIONAL_IN = 7;
    const USER_MANAGER_NATIONAL_OUT = 8;
    const USER_MANAGER_TEAM_IN = 3;
    const USER_MANAGER_TEAM_OUT = 4;
    const USER_PRESIDENT_IN = 11;
    const USER_PRESIDENT_OUT = 12;
    const USER_VICE_NATIONAL_IN = 9;
    const USER_VICE_NATIONAL_OUT = 10;
    const USER_VICE_PRESIDENT_IN = 13;
    const USER_VICE_PRESIDENT_OUT = 14;
    const USER_VICE_TEAM_IN = 5;
    const USER_VICE_TEAM_OUT = 6;
    const VIP_1_PLACE = 21;
    const VIP_2_PLACE = 22;
    const VIP_3_PLACE = 23;
    const VIP_FINAL = 25;
    const VIP_WINNER = 24;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%history_text}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['history_text_id'], 'integer'],
            [['history_text_text'], 'required'],
            [['history_text_text'], 'string', 'max' => 255],
            [['history_text_text'], 'trim'],
        ];
    }
}
