<?php

namespace console\models\generator;

use common\models\Site;
use DateTime;
use DateTimeZone;
use Yii;

/**
 * Class CheckCronDate
 * @package console\models\generator
 */
class CheckCronDate
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute(): void
    {
        $formattedTime = (new DateTime('now', new DateTimeZone('UTC')))->format('H:i');
        print '<pre>';
        print_r($formattedTime);
        exit;
        $dateCron = Site::find()->select(['site_date_cron'])->where(['site_id' => 1])->limit(1)->scalar();

        if (!$dateCron) {
            Yii::$app->end();
        }

        if (date('Y-m-d', $dateCron) == date('Y-m-d')) {
            Yii::$app->end();
        }

        $formattedTime = (new DateTime('now', new DateTimeZone('UTC')))->format('H:i');
        if (!in_array($formattedTime, ['08:57', '08:58', '08:59', '09:00', '09:01', '09:02', '09:03'])) {
            Yii::$app->end();
        }
    }
}