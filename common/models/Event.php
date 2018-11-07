<?php

namespace common\models;

/**
 * Class Event
 * @package common\models
 *
 * @property int $event_id
 * @property int $event_event_text_goal_id
 * @property int $event_event_text_penalty_id
 * @property int $event_event_text_shootout_id
 * @property int $event_event_type_id
 * @property int $event_game_id
 * @property int $event_guest_score
 * @property int $event_home_score
 * @property int $event_minute
 * @property int $event_national_id
 * @property int $event_player_assist_1_id
 * @property int $event_player_assist_2_id
 * @property int $event_player_penalty_id
 * @property int $event_player_score_id
 * @property int $event_second
 * @property int $event_team_id
 */
class Event extends AbstractActiveRecord
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
     * @throws \Exception
     */
    public static function log(array $data)
    {
        $history = new self();
        $history->setAttributes($data);
        $history->save();
    }
}
