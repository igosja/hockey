<?php

namespace frontend\controllers;

use common\models\Loan;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class LoanController
 * @package frontend\controllers
 */
class LoanController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Loan::find()
            ->where(['loan_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Аренда хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
