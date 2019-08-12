<?php

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * Class Season
 * @package common\models
 *
 * @property int $season_id
 */
class Season extends AbstractActiveRecord
{
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
        $result = self::find()->max('season_id');
        return $result;
    }

    /**
     * @return array
     */
    public static function getSeasonArray(): array
    {
        $result = self::find()
            ->orderBy(['season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($result, 'season_id', 'season_id');
    }
}
