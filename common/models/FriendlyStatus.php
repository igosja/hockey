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
     * @return string
     */
    public static function tableName()
    {
        return '{{%friendly_status}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['friendly_status_id'], 'integer'],
            [['friendly_status_name'], 'integer'],
        ];
    }
}
