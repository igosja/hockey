<?php

namespace frontend\controllers;

use common\models\Message;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class MessengerController
 * @package frontend\controllers
 */
class MessengerController extends AbstractController
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
     * @return string
     */
    public function actionIndex()
    {
        $this->setSeoTitle('Личная переписка');

        $query = Message::find()
            ->select([
                'message_id' => 'MAX(`message_id`)',
                'message_user_id' => 'IF(`message_user_id_to`=' . Yii::$app->user->id . ', `message_user_id_from`, `message_user_id_to`)',
                'message_user_id_from',
                'message_user_id_to',
                'message_read' => 'MIN(IF(`message_user_id_to`=' . Yii::$app->user->id . ', IF(`message_read`=0, `message_read`, 1), 1))',
            ])
            ->where([
                'or',
                ['message_user_id_from' => Yii::$app->user->id],
                ['message_user_id_to' => Yii::$app->user->id]
            ])
            ->groupBy('message_user_id')
            ->orderBy(['message_read' => SORT_ASC, 'message_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \Exception
     */
    public function actionView($id)
    {
        $user = User::find()
            ->where(['user_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($user);

        $model = new Message();
        if ($model->addMessage($id)) {
            $this->setSuccessFlash('Сообщение успешно сохраненo');
            return $this->refresh();
        }

        $messageArray = Message::find()
            ->where([
                'or',
                ['message_user_id_from' => $id, 'message_user_id_to' => Yii::$app->user->id],
                ['message_user_id_from' => Yii::$app->user->id, 'message_user_id_to' => $id]
            ])
            ->limit(Yii::$app->params['pageSizeMessage'])
            ->orderBy(['message_id' => SORT_DESC])
            ->all();

        $countMessage = Message::find()
            ->where([
                'or',
                ['message_user_id_from' => $id, 'message_user_id_to' => Yii::$app->user->id],
                ['message_user_id_from' => Yii::$app->user->id, 'message_user_id_to' => $id]
            ])
            ->count();

        $lazy = 0;
        if ($countMessage > count($messageArray)) {
            $lazy = 1;
        }

        Message::updateAll(
            ['message_read' => time()],
            ['message_read' => 0, 'message_user_id_to' => Yii::$app->user->id, 'message_user_id_from' => $id]
        );

        $this->setSeoTitle('Личная переписка');

        return $this->render('view', [
            'lazy' => $lazy,
            'model' => $model,
            'messageArray' => $messageArray,
        ]);
    }
}
