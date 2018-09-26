<?php

namespace common\models;

use yii\db\ActiveRecord;

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
 */
class FriendlyInvite extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%friendly_invite}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
}
