<?php

namespace common\models;

/**
 * Class ElectionNational
 * @package common\models
 *
 * @property int $election_status_id
 * @property string $election_status_name
 */
class ElectionStatus extends AbstractActiveRecord
{
    const CANDIDATES = 1;
    const CLOSE = 3;
    const OPEN = 2;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_status}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['election_status_id'], 'integer'],
            [['election_status_name'], 'required'],
            [['election_status_name'], 'string', 'max' => 255],
            [['election_status_name'], 'trim'],
        ];
    }
}
