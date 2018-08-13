<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Site
 * @package common\models
 *
 * @property integer $site_id
 * @property integer $site_date_cron
 * @property integer $site_status
 * @property integer $site_version_1
 * @property integer $site_version_2
 * @property integer $site_version_3
 * @property integer $site_version_date
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

        $site = self::find()
            ->select(['site_version_1', 'site_version_2', 'site_version_3', 'site_version_date'])
            ->where(['site_id' => 1])
            ->one();
        if ($site) {
            $version = $site->site_version_1 . '.' . $site->site_version_2 . '.' . $site->site_version_3;
            $date = $site->site_version_date;
        }

        $result = 'Version ' . $version . ' dated ';

        try {
            $result = $result . Yii::$app->formatter->asDate($date);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        return $result;
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
