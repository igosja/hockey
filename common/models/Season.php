<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Season
 * @package common\models
 *
 * @property int $season_id
 */
class Season extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%season}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['season_id'], 'integer'],
        ];
    }

    /**
     * @return int
     */
    public static function getCurrentSeason(): int
    {
        return self::find()->max('season_id');
    }
}
