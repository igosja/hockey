<?php

namespace frontend\controllers;

use frontend\models\Chat;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class ChatController
 * @package frontend\controllers
 */
class ChatController extends AbstractController
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
     * @return array|string|Response
     */
    public function actionIndex()
    {
        $model = new Chat();
        if ($model->save()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true];
            } else {
                return $this->refresh();
            }
        }

        $chatArray = $model->chatArray();
        if (!is_array($chatArray)) {
            $chatArray = [];
        }

        $this->setSeoTitle('Чат');

        return $this->render('index', [
            'chatArray' => $chatArray,
            'model' => $model,
        ]);
    }
}
