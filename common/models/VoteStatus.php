<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class VoteStatus
 * @package common\models
 *
 * @property int $vote_status_id
 * @property int $vote_status_name
 */
class VoteStatus extends ActiveRecord
{
    const CLOSE = 3;
    const NEW = 1;
    const OPEN = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%vote_status}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['vote_status_id'], 'integer'],
            [['vote_status_name'], 'required'],
            [['vote_status_name'], 'string', 'max' => 255],
            [['vote_status_name'], 'trim'],
        ];
    }
}
