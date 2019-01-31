<?php

namespace backend\controllers;

use common\models\ForumMessage;
use common\models\GameComment;
use common\models\LoanComment;
use common\models\News;
use common\models\NewsComment;
use common\models\Review;
use common\models\TransferComment;
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
    public function actionIndex()
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
     * @throws \Exception
     */
    public function actionForumMessageUpdate($id)
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
    public function actionForumMessageOk($id)
    {
        ForumMessage::updateAll(['forum_message_check' => time()], ['forum_message_id' => $id]);
        return $this->redirect(['moderation/forum-message']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionForumMessageDelete($id)
    {
        $model = ForumMessage::find()
            ->where(['forum_message_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
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
     * @throws \Exception
     */
    public function actionGameCommentUpdate($id)
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
    public function actionGameCommentOk($id)
    {
        GameComment::updateAll(['game_comment_check' => time()], ['game_comment_id' => $id]);
        return $this->redirect(['moderation/game-comment']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionGameCommentDelete($id)
    {
        $model = GameComment::find()
            ->where(['game_comment_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/game-comment']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionNewsComment()
    {
        $model = NewsComment::find()
            ->where(['news_comment_check' => 0])
            ->orderBy(['news_comment_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/loan-comment']);
        }

        $this->view->title = 'Комментарии к новостям';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('news-comment', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \Exception
     */
    public function actionNewsCommentUpdate($id)
    {
        $model = NewsComment::find()
            ->where(['news_comment_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/news-comment']);
        }

        $this->view->title = 'Комментарии к новостям';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('news-comment-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionNewsCommentOk($id)
    {
        NewsComment::updateAll(['news_comment_check' => time()], ['news_comment_id' => $id]);
        return $this->redirect(['moderation/news-comment']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionNewsCommentDelete($id)
    {
        $model = NewsComment::find()
            ->where(['news_comment_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/news-comment']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionNews()
    {
        $model = News::find()
            ->where(['news_check' => 0])
            ->orderBy(['news_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/news-comment']);
        }

        $this->view->title = 'Новости';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('news', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \Exception
     */
    public function actionNewsUpdate($id)
    {
        $model = News::find()
            ->where(['news_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/news']);
        }

        $this->view->title = 'Новости';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('news-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionNewsOk($id)
    {
        News::updateAll(['news_check' => time()], ['news_id' => $id]);
        return $this->redirect(['moderation/news']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionNewsDelete($id)
    {
        $model = News::find()
            ->where(['news_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/news']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionLoanComment()
    {
        $model = LoanComment::find()
            ->where(['loan_comment_check' => 0])
            ->orderBy(['loan_comment_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/transfer-comment']);
        }

        $this->view->title = 'Комментарии к аренде';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('loan-comment', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \Exception
     */
    public function actionLoanCommentUpdate($id)
    {
        $model = LoanComment::find()
            ->where(['loan_comment_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/loan-comment']);
        }

        $this->view->title = 'Комментарии к аренде';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('loan-comment-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionLoanCommentOk($id)
    {
        LoanComment::updateAll(['loan_comment_check' => time()], ['loan_comment_id' => $id]);
        return $this->redirect(['moderation/loan-comment']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLoanCommentDelete($id)
    {
        $model = LoanComment::find()
            ->where(['loan_comment_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/loan-comment']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionTransferComment()
    {
        $model = TransferComment::find()
            ->where(['transfer_comment_check' => 0])
            ->orderBy(['transfer_comment_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['moderation/review']);
        }

        $this->view->title = 'Комментарии к трансферам';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('transfer-comment', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \Exception
     */
    public function actionTransferCommentUpdate($id)
    {
        $model = TransferComment::find()
            ->where(['transfer_comment_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/transfer-comment']);
        }

        $this->view->title = 'Комментарии к трансферам';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('transfer-comment-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionTransferCommentOk($id)
    {
        TransferComment::updateAll(['transfer_comment_check' => time()], ['transfer_comment_id' => $id]);
        return $this->redirect(['moderation/transfer-comment']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTransferCommentDelete($id)
    {
        $model = TransferComment::find()
            ->where(['transfer_comment_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/transfer-comment']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionReview()
    {
        $model = Review::find()
            ->where(['review_check' => 0])
            ->orderBy(['review_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$model) {
            return $this->redirect(['site/index']);
        }

        $this->view->title = 'Обзоры туров';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('review', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \Exception
     */
    public function actionReviewUpdate($id)
    {
        $model = Review::find()
            ->where(['review_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['moderation/review']);
        }

        $this->view->title = 'Обзоры туров';
        $this->view->params['breadcrumbs'][] = ['label' => 'Модерация', 'url' => ['moderation/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('review-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionReviewOk($id)
    {
        Review::updateAll(['review_check' => time()], ['review_id' => $id]);
        return $this->redirect(['moderation/review']);
    }

    /**
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionReviewDelete($id)
    {
        $model = Review::find()
            ->where(['review_id' => $id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['moderation/review']);
    }
}
