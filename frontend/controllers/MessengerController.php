<?php

namespace frontend\controllers;

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Blacklist;
use common\models\Message;
use common\models\User;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
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
        $query = Message::find()
            ->select([
                'message_id' => 'MAX(`message_id`)',
                'message_user_id' => 'IF(`message_user_id_to`=' . $this->user->user_id . ', `message_user_id_from`, `message_user_id_to`)',
                'message_user_id_from',
                'message_user_id_to',
                'message_read' => 'MIN(IF(`message_user_id_to`=' . $this->user->user_id . ', IF(`message_read`=0, `message_read`, 1), 1))',
            ])
            ->where([
                'or',
                ['message_user_id_from' => $this->user->user_id],
                ['message_user_id_to' => $this->user->user_id]
            ])
            ->groupBy('message_user_id')
            ->orderBy(['message_read' => SORT_ASC, 'message_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('Личная переписка');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
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
                ['message_user_id_from' => $id, 'message_user_id_to' => $this->user->user_id],
                ['message_user_id_from' => $this->user->user_id, 'message_user_id_to' => $id]
            ])
            ->limit(Yii::$app->params['pageSizeMessage'])
            ->orderBy(['message_id' => SORT_DESC])
            ->all();

        $countMessage = Message::find()
            ->where([
                'or',
                ['message_user_id_from' => $id, 'message_user_id_to' => $this->user->user_id],
                ['message_user_id_from' => $this->user->user_id, 'message_user_id_to' => $id]
            ])
            ->count();

        $lazy = 0;
        if ($countMessage > count($messageArray)) {
            $lazy = 1;
        }

        Message::updateAll(
            ['message_read' => time()],
            ['message_read' => 0, 'message_user_id_to' => $this->user->user_id, 'message_user_id_from' => $id]
        );

        $inBlacklistOwner = Blacklist::find()
            ->where(['blacklist_owner_user_id' => $this->user->user_id, 'blacklist_interlocutor_user_id' => $id])
            ->count();

        $inBlacklistInterlocutor = Blacklist::find()
            ->where(['blacklist_owner_user_id' => $id, 'blacklist_interlocutor_user_id' => $this->user->user_id])
            ->count();

        $this->setSeoTitle('Личная переписка');

        return $this->render('view', [
            'inBlacklistInterlocutor' => $inBlacklistInterlocutor,
            'inBlacklistOwner' => $inBlacklistOwner,
            'lazy' => $lazy,
            'model' => $model,
            'messageArray' => array_reverse($messageArray),
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function actionLoad($id)
    {
        $messageArray = Message::find()
            ->where([
                'or',
                ['message_user_id_from' => $id, 'message_user_id_to' => $this->user->user_id],
                ['message_user_id_from' => $this->user->user_id, 'message_user_id_to' => $id]
            ])
            ->offset(Yii::$app->request->get('offset'))
            ->limit(Yii::$app->request->get('limit'))
            ->orderBy(['message_id' => SORT_DESC])
            ->all();
        $messageArray = array_reverse($messageArray);

        $countMessage = Message::find()
            ->where([
                'or',
                ['message_user_id_from' => $id, 'message_user_id_to' => $this->user->user_id],
                ['message_user_id_from' => $this->user->user_id, 'message_user_id_to' => $id]
            ])
            ->count();

        if ($countMessage > count($messageArray) + Yii::$app->request->get('offset')) {
            $lazy = 1;
        } else {
            $lazy = 0;
        }

        $list = '';

        foreach ($messageArray as $message) {
            /**
             * @var Message $message
             */
            $list = $list
                . '<div class="row margin-top"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">'
                . FormatHelper::asDateTime($message->message_date)
                . ', '
                . $message->userFrom->userLink()
                . '</div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message '
                . ($this->user->user_id == $message->message_user_id_from ? 'message-from-me' : 'message-to-me')
                . '">'
                . HockeyHelper::bbDecode($message->message_text)
                . '</div></div>';
        }

        $result = [
            'offset' => Yii::$app->request->get('offset') + Yii::$app->request->get('limit'),
            'lazy' => $lazy,
            'list' => $list,
        ];

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
