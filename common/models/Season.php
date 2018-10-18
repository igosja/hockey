<?php

namespace common\models;

use common\components\ErrorHelper;
use Throwable;
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
        try {
            $result = self::getDb()->cache(function (): int {
                return self::find()->max('season_id');
            });
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $result = self::find()->max('season_id');
        }
        return $result;
    }
}
