<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ElectionNational
 * @package common\models
 *
 * @property int $election_status_id
 * @property string $election_status_name
 */
class ElectionStatus extends ActiveRecord
{
    const CANDIDATES = 1;
    const CLOSE = 3;
    const OPEN = 2;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_status}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['election_status_id'], 'integer'],
            [['election_status_name'], 'required'],
            [['election_status_name'], 'string', 'max' => 255],
            [['election_status_name'], 'trim'],
        ];
    }
}
