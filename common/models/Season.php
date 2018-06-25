<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Season
 * @package common\models
 *
 * @property integer $season_id
 */
class Season extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%season}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['season_id'], 'integer'],
        ];
    }
}
