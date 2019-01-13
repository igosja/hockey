<?php

namespace frontend\controllers;

use common\models\User;
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

        $this->setSeoTitle('Чат');

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionMessage($lastDate = 0)
    {
        $chatArray = (new Chat())->chatArray($lastDate);
        if (!is_array($chatArray)) {
            $chatArray = [];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $chatArray;
    }

    /**
     * @return array
     */
    public function actionUser()
    {
        $result = [];
        $userArray = User::find()
            ->select(['user_login', 'user_id'])
            ->where('`user_date_login`>UNIX_TIMESTAMP()-300')
            ->orderBy(['user_login' => SORT_ASC])
            ->all();
        foreach ($userArray as $user) {
            $result[] = [
                'user' => $user->userLink(['target' => '_blank']),
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
