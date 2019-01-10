<?php

namespace common\models;

/**
 * Class FriendlyInviteStatus
 * @package common\models
 *
 * @property int $friendly_invite_status_id
 * @property string $friendly_invite_status_name
 */
class FriendlyInviteStatus extends AbstractActiveRecord
{
    const ACCEPTED = 2;
    const CANCELED = 3;
    const NEW_ONE = 1;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%friendly_invite_status}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['friendly_invite_status_id'], 'integer'],
            [['friendly_invite_status_name'], 'integer'],
        ];
    }
}
