<?php

namespace common\models;

use yii\db\ActiveQuery;

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
 *
 * @property EventTextGoal $eventTextGoal
 * @property EventTextPenalty $eventTextPenalty
 * @property EventTextShootout $eventTextShootout
 * @property EventType $eventType
 * @property National $national
 * @property Player $playerAssist1
 * @property Player $playerAssist2
 * @property Player $playerPenalty
 * @property Player $playerScore
 * @property Team $team
 */
class Event extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * @return array
     */
    public function rules()
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
        $event = new self();
        $event->setAttributes($data);
        $event->save();
    }

    /**
     * @return ActiveQuery
     */
    public function getEventTextGoal()
    {
        return $this->hasOne(EventTextGoal::class, ['event_text_goal_id' => 'event_event_text_goal_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getEventTextPenalty()
    {
        return $this->hasOne(EventTextPenalty::class,
            ['event_text_penalty_id' => 'event_event_text_penalty_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getEventTextShootout()
    {
        return $this->hasOne(EventTextShootout::class,
            ['event_text_shootout_id' => 'event_event_text_shootout_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne(EventType::class, ['event_type_id' => 'event_event_type_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getNational()
    {
        return $this->hasOne(National::class, ['national_id' => 'event_national_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerAssist1()
    {
        return $this->hasOne(Player::class, ['player_id' => 'event_player_assist_1_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerAssist2()
    {
        return $this->hasOne(Player::class, ['player_id' => 'event_player_assist_2_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerPenalty()
    {
        return $this->hasOne(Player::class, ['player_id' => 'event_player_penalty_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerScore()
    {
        return $this->hasOne(Player::class, ['player_id' => 'event_player_score_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'event_team_id'])->cache();
    }
}
