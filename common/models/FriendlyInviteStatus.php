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
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%friendly_invite_status}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['friendly_invite_status_id'], 'integer'],
            [['friendly_invite_status_name'], 'integer'],
        ];
    }
}
