<?php

namespace console\models\generator;

use common\models\National;
use common\models\NationalUserDay;

/**
 * Class IncreaseNationalUserDay
 * @package console\models\generator
 */
class IncreaseNationalUserDay
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $nationalArray = National::find()
            ->where(['!=', 'national_user_id', 0])
            ->orWhere(['!=', 'national_vice_id', 0])
            ->orderBy(['national_id' => SORT_ASC])
            ->each();
        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            if ($national->national_user_id) {
                $model = NationalUserDay::find()
                    ->where([
                        'national_user_day_national_id' => $national->national_id,
                        'national_user_day_user_id' => $national->national_user_id,
                    ])
                    ->limit(1)
                    ->one();
                if (!$model) {
                    $model = new NationalUserDay();
                    $model->national_user_day_national_id = $national->national_id;
                    $model->national_user_day_user_id = $national->national_user_id;
                }

                $model->national_user_day_day = $model->national_user_day_day + 2;
                $model->save();
            }

            if ($national->national_vice_id) {
                $model = NationalUserDay::find()
                    ->where([
                        'national_user_day_national_id' => $national->national_id,
                        'national_user_day_user_id' => $national->national_vice_id,
                    ])
                    ->limit(1)
                    ->one();
                if (!$model) {
                    $model = new NationalUserDay();
                    $model->national_user_day_national_id = $national->national_id;
                    $model->national_user_day_user_id = $national->national_vice_id;
                }

                $model->national_user_day_day = $model->national_user_day_day + 1;
                $model->save();
            }
        }
    }
}
