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
    public function behaviors(): array
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
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new Chat();
        if ($model->save()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return 'ok';
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
