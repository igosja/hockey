<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Throwable;
use Yii;

/**
 * Class Site
 * @package common\models
 *
 * @property int $site_id
 * @property int $site_date_cron
 * @property int $site_status
 * @property int $site_version_1
 * @property int $site_version_2
 * @property int $site_version_3
 * @property int $site_version_date
 */
class Site extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%site}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'site_id',
                    'site_date_cron',
                    'site_status',
                    'site_version_1',
                    'site_version_2',
                    'site_version_3',
                    'site_version_date',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return string
     */
    public static function version(): string
    {
        $version = '0.0.0';
        $date = time();

        try {
            $site = self::getDb()->cache(function (): self {
                return self::find()
                    ->select(['site_version_1', 'site_version_2', 'site_version_3', 'site_version_date'])
                    ->where(['site_id' => 1])
                    ->one();
            });
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $site = self::find()
                ->select(['site_version_1', 'site_version_2', 'site_version_3', 'site_version_date'])
                ->where(['site_id' => 1])
                ->one();
        }

        if ($site) {
            $version = $site->site_version_1 . '.' . $site->site_version_2 . '.' . $site->site_version_3;
            $date = $site->site_version_date;
        }

        try {
            $date = Yii::$app->formatter->asDate($date);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return 'Версия ' . $version . ' от ' . $date;
    }

    /**
     * @return int
     */
    public static function status(): int
    {
        try {
            $site = self::getDb()->cache(function (): self {
                return self::find()
                    ->select(['site_status'])
                    ->where(['site_id' => 1])
                    ->one();
            });
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $site = self::find()
                ->select(['site_status'])
                ->where(['site_id' => 1])
                ->one();
        }

        $result = 1;
        if ($site) {
            $result = $site->site_status;
        }

        return $result;
    }

    /**
     * @return void
     */
    public static function switchStatus(): void
    {
        $model = Site::find()
            ->where(['site_id' => 1])
            ->one();
        $model->site_status = 1 - $model->site_status;
        $model->save();
    }
}
