<?php

namespace frontend\controllers;

use common\models\Transfer;
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
        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Transfer::PAGE_LIMIT,
            ],
            'query' => Transfer::find()
                ->where(['transfer_ready' => 0]),
            'sort' => [
                'attributes' => [
                    'price' => [
                        'asc' => ['transfer_price_seller' => SORT_ASC],
                        'desc' => ['transfer_price_seller' => SORT_DESC],
                    ],
                    'transfer_id' => [
                        'asc' => ['transfer_id' => SORT_ASC],
                        'desc' => ['transfer_id' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['transfer_id' => SORT_ASC],
            ],
        ]);

        $this->view->title = 'Federation teams';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Federation teams - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
