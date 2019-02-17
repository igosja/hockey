<?php

namespace backend\controllers;

use common\components\Controller;
use Yii;
use yii\filters\AccessControl;

/**
 * Class AbstractController
 * @package backend\controllers
 *
 * @property string $layout
 */
abstract class AbstractController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ('ru' != Yii::$app->language) {
            Yii::$app->language = 'ru';
        }

        $allowedIp = [
            '62.205.148.101',//Peremohy-60
            '185.38.209.242',//Zhabaeva-7
            '31.172.137.26',//Zhabaeva-7
            '127.0.0.1',
        ];

        if (!in_array(Yii::$app->request->userIP, $allowedIp)) {
            Yii::$app->request->setBaseUrl('');
            return $this->redirect(['site/index']);
        }

        return true;
    }
}
