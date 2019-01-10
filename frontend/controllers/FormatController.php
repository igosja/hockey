<?php

namespace frontend\controllers;

use common\components\FormatHelper;
use Yii;
use yii\web\Response;

/**
 * Class FormatController
 * @package frontend\controllers
 */
class FormatController extends AbstractController
{
    /**
     * @return array
     */
    public function actionCurrency()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'value' => FormatHelper::asCurrency(Yii::$app->request->get('value')),
        ];
    }
}
