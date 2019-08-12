<?php

namespace common\models;

/**
 * Class FriendlyStatus
 * @package common\models
 *
 * @property int $friendly_status_id
 * @property string $friendly_status_name
 */
class FriendlyStatus extends AbstractActiveRecord
{
    const ALL = 1;
    const NONE = 3;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['friendly_status_id'], 'integer'],
            [['friendly_status_name'], 'integer'],
        ];
    }
}
