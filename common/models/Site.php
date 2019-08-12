<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
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

        $site = self::find()
            ->where(['site_id' => 1])
            ->one();

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
        $site = self::find()
            ->where(['site_id' => 1])
            ->one();

        $result = 1;
        if ($site) {
            $result = $site->site_status;
        }

        return $result;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public static function switchStatus(): bool
    {
        $model = Site::find()
            ->where(['site_id' => 1])
            ->one();
        $model->site_status = 1 - $model->site_status;
        $model->save();

        return true;
    }
}
