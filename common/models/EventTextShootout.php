<?php

namespace common\models;

/**
 * Class EventTextShootout
 * @package common\models
 *
 * @property int $event_text_shootout_id
 * @property string $event_text_shootout_text
 */
class EventTextShootout extends AbstractActiveRecord
{
    const NO_SCORE = 2;
    const SCORE = 1;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['event_text_shootout_id'], 'integer'],
            [['event_text_shootout_text'], 'string', 'max' => 255],
        ];
    }
}
