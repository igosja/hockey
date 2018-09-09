<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Event
 * @package common\models
 *
 * @property integer $event_id
 * @property integer $event_event_text_goal_id
 * @property integer $event_event_text_penalty_id
 * @property integer $event_event_text_shootout_id
 * @property integer $event_event_type_id
 * @property integer $event_game_id
 * @property integer $event_guest_score
 * @property integer $event_home_score
 * @property integer $event_minute
 * @property integer $event_national_id
 * @property integer $event_player_assist_1_id
 * @property integer $event_player_assist_2_id
 * @property integer $event_player_penalty_id
 * @property integer $event_player_score_id
 * @property integer $event_second
 * @property integer $event_team_id
 */
class Event extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%event}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'event_id',
                    'event_event_text_goal_id',
                    'event_event_text_penalty_id',
                    'event_event_text_shootout_id',
                    'event_event_type_id',
                    'event_game_id',
                    'event_guest_score',
                    'event_home_score',
                    'event_minute',
                    'event_national_id',
                    'event_player_assist_1_id',
                    'event_player_assist_2_id',
                    'event_player_penalty_id',
                    'event_player_score_id',
                    'event_second',
                    'event_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @param array $data
     */
    public static function log(array $data)
    {
        $history = new self();
        $history->setAttributes($data);
        $history->save();
    }
}
