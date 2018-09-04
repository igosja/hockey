<?php

namespace console\models\generator;

use common\models\Site;
use Yii;

/**
 * Class CheckCronDate
 * @package console\models\generator
 */
class CheckCronDate
{
    /**
     * @throws \yii\base\ExitException
     */
    public function execute()
    {
        $dateCron = Site::find()->select(['site_date_cron'])->where(['site_id' => 1])->limit(1)->scalar();

        if (!$dateCron) {
            Yii::$app->end();
        }

        if (date('Y-m-d', $dateCron) == date('Y-m-d')) {
            Yii::$app->end();
        }

        if (!in_array(date('H:i'), [
            '11:56',
            '11:57',
            '11:58',
            '11:59',
            '12:00',
            '12:01',
            '12:02',
            '12:03',
            '12:04',
        ])) {
            Yii::$app->end();
        }
    }
}