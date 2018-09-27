<?php

namespace console\models\start;

use common\components\ErrorHelper;
use common\models\City;
use common\models\National;
use common\models\NationalType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertNational
 * @package console\models\start
 */
class InsertNational
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute(): void
    {
        $nationalTypeArray = NationalType::find()->select(['national_type_id'])->all();
        $cityArray = City::find()
            ->select(['city_country_id'])
            ->where(['!=', 'city_country_id', 0])
            ->groupBy('city_country_id')
            ->orderBy(['city_country_id' => SORT_ASC])
            ->all();

        foreach ($cityArray as $city) {
            foreach ($nationalTypeArray as $nationalType) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $national = new National();
                    $national->national_national_type_id = $nationalType->national_type_id;
                    $national->national_country_id = $city->city_country_id;
                    if (!$national->save()) {
                        throw new Exception(ErrorHelper::modelErrorsToString($national));
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }
    }
}
