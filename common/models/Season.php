<?php

namespace common\models;

use common\components\ErrorHelper;
use Throwable;
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

    /**
     * @return int
     */
    public static function getCurrentSeason()
    {
        try {
            $result = self::getDb()->cache(function () {
                return self::find()->max('season_id');
            });
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $result = self::find()->max('season_id');
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getSeasonArray()
    {
        $result = self::find()
            ->orderBy(['season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($result, 'season_id', 'season_id');
    }
}
