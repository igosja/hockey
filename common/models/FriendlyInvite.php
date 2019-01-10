<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class FriendlyInvite
 * @package common\models
 *
 * @property int $friendly_invite_id
 * @property int $friendly_invite_date
 * @property int $friendly_invite_friendly_invite_status_id
 * @property int $friendly_invite_guest_team_id
 * @property int $friendly_invite_guest_user_id
 * @property int $friendly_invite_home_team_id
 * @property int $friendly_invite_home_user_id
 * @property int $friendly_invite_schedule_id
 *
 * @property FriendlyInviteStatus $friendlyInviteStatus
 * @property Team $guestTeam
 * @property Team $homeTeam
 */
class FriendlyInvite extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%friendly_invite}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'friendly_invite_id',
                    'friendly_invite_date',
                    'friendly_invite_friendly_invite_status_id',
                    'friendly_invite_guest_team_id',
                    'friendly_invite_guest_user_id',
                    'friendly_invite_home_team_id',
                    'friendly_invite_home_user_id',
                    'friendly_invite_schedule_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->friendly_invite_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getFriendlyInviteStatus()
    {
        return $this->hasOne(
            FriendlyInviteStatus::class,
            ['friendly_invite_status_id' => 'friendly_invite_friendly_invite_status_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getGuestTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'friendly_invite_guest_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getHomeTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'friendly_invite_home_team_id']);
    }
}
