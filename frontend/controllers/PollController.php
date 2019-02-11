<?php

namespace frontend\controllers;

use common\models\Poll;
use common\models\PollAnswer;
use common\models\PollStatus;
use common\models\PollUser;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class PollController
 * @package frontend\controllers
 */
class PollController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['poll'],
                'rules' => [
                    [
                        'actions' => ['poll'],
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
        Poll::updateAll(
            ['poll_poll_status_id' => PollStatus::CLOSE],
            [
                'and',
                ['poll_poll_status_id' => PollStatus::OPEN],
                ['<', 'poll_date', time() - 604800]
            ]
        );

        $countryId = [0];
        if ($this->myTeam) {
            $countryId[] = $this->myTeam->stadium->city->country->country_id;
        }

        $query = Poll::find()
            ->where(['poll_poll_status_id' => [PollStatus::OPEN, PollStatus::CLOSE]])
            ->andWhere(['poll_country_id' => $countryId])
            ->orderBy(['poll_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizePoll'],
            ],
        ]);

        $this->setSeoTitle('Опросы');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $poll = Poll::find()
            ->where(['poll_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($poll);

        if (!Yii::$app->user->isGuest) {
            if (PollStatus::OPEN == $poll->poll_poll_status_id && (!$poll->poll_country_id || ($this->myTeam && $this->myTeam->stadium->city->country->country_id == $poll->poll_country_id))) {
                $pollUser = PollUser::find()
                    ->where([
                        'poll_user_poll_answer_id' => PollAnswer::find()
                            ->select(['poll_answer_id'])
                            ->where(['poll_answer_poll_id' => $id]),
                        'poll_user_user_id' => Yii::$app->user->id,
                    ])
                    ->count();
                if (!$pollUser) {
                    return $this->redirect(['poll/poll', 'id' => $id]);
                }
            }
        }

        $this->setSeoTitle('Опрос');

        return $this->render('view', [
            'poll' => $poll,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPoll($id)
    {
        $poll = Poll::find()->where(['poll_id' => $id])->one();
        $this->notFound($poll);

        if (PollStatus::OPEN != $poll->poll_poll_status_id) {
            return $this->redirect(['poll/view', 'id' => $id]);
        }

        if ($poll->poll_country_id && (!$this->myTeam || $this->myTeam->stadium->city->country->country_id != $poll->poll_country_id)) {
            return $this->redirect(['poll/view', 'id' => $id]);
        }

        $pollUser = PollUser::find()
            ->where([
                'poll_user_poll_answer_id' => PollAnswer::find()
                    ->select(['poll_answer_id'])
                    ->where(['poll_answer_poll_id' => $id]),
                'poll_user_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if ($pollUser) {
            return $this->redirect(['poll/view', 'id' => $id]);
        }

        $model = new PollUser();

        if ($model->addAnswer()) {
            $this->setSuccessFlash('Ваш голос успешно сохранён');
            return $this->redirect(['poll/view', 'id' => $id]);
        }

        $this->setSeoTitle('Опрос');

        return $this->render('poll', [
            'model' => $model,
            'poll' => $poll,
        ]);
    }
}
