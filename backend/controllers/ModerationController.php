<?php

namespace backend\controllers;

use common\models\ForumMessage;
use common\models\GameComment;
use Yii;
use yii\web\Response;

/**
 * Class ModerationController
 * @package backend\controllers
 */
class ModerationController extends AbstractController
{
    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->redirect(['moderation/forum-message']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionForumMessage()
    {
        $model = ForumMessage::find()
            ->where(['forum_message_check' => 0])
            ->orderBy(['forum_message_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/game-comment']);
        }

        $this->view->title = 'Сообщение на форуме';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('forum-message', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionForumMessageUpdate(int $id)
    {
        $model = ForumMessage::find()
            ->where(['forum_message_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/forum-message']);
        }

        $this->view->title = 'Сообщение на форуме';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('forum-message-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionForumMessageOk(int $id)
    {
        ForumMessage::updateAll(['forum_message_check' => time()], ['forum_message_id' => $id]);
        return $this->redirect(['moderation/forum-message']);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionForumMessageDelete(int $id)
    {
        ForumMessage::deleteAll(['forum_message_id' => $id]);
        return $this->redirect(['moderation/forum-message']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionGameComment()
    {
        $model = GameComment::find()
            ->where(['game_comment_check' => 0])
            ->orderBy(['game_comment_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/news']);
        }

        $this->view->title = 'Комментарий к матчу';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('game-comment', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionGameCommentUpdate(int $id)
    {
        $model = GameComment::find()
            ->where(['game_comment_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/game-comment']);
        }

        $this->view->title = 'Комментарий к матчу';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('game-comment-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionGameCommentOk(int $id)
    {
        GameComment::updateAll(['game_comment_check' => time()], ['game_comment_id' => $id]);
        return $this->redirect(['moderation/game-comment']);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionGameCommentDelete(int $id)
    {
        GameComment::deleteAll(['game_comment_id' => $id]);
        return $this->redirect(['moderation/game-comment']);
    }
}
