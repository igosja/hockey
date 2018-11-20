<?php

namespace frontend\controllers;

use common\models\Transfer;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class TransferController
 * @package frontend\controllers
 */
class TransferController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Transfer::find()
            ->where(['transfer_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Трансфер хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
