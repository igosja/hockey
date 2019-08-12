<?php

namespace common\models;

/**
 * Class PollStatus
 * @package common\models
 *
 * @property int $poll_status_id
 * @property int $poll_status_name
 */
class PollStatus extends AbstractActiveRecord
{
    const CLOSE = 3;
    const NEW_ONE = 1;
    const OPEN = 2;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['poll_status_id'], 'integer'],
            [['poll_status_name'], 'required'],
            [['poll_status_name'], 'string', 'max' => 255],
            [['poll_status_name'], 'trim'],
        ];
    }
}
