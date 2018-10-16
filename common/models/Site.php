<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveRecord;

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
class Site extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%site}}';
    }

    /**
     * @return string
     */
    public static function version(): string
    {
        $version = '0.0.0';
        $date = time();

        try {
            $site = self::getDb()->cache(function () {
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
                ->one();;
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

        return Yii::t('common-models-site', 'version', ['version' => $version, 'date' => $date]);
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
}
