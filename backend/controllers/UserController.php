<?php

namespace backend\controllers;

use backend\models\UserSearch;
use common\models\BlockReason;
use common\models\Cookie;
use common\models\Payment;
use common\models\User;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Пользователи';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $query = User::find()
            ->where(['user_ip' => $model->user_ip])
            ->andWhere(['!=', 'user_id', $model->user_id]);
        $ipDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Cookie::find()
            ->where(['cookie_user_1_id' => $model->user_id])
            ->orWhere(['cookie_user_2_id' => $model->user_id]);
        $cookieDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'cookieDataProvider' => $cookieDataProvider,
            'ipDataProvider' => $ipDataProvider,
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['user/view', 'id' => $model->user_id]);
        }

        $this->view->title = 'Редактирование причины блокировки';
        $this->view->params['breadcrumbs'][] = ['label' => 'Стадии соревнований', 'url' => ['stage/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->user_login,
            'url' => ['user/view', 'id' => $model->user_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionAuth($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        Yii::$app->request->setBaseUrl('');
        return $this->redirect(['site/auth', 'code' => $model->user_code]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionPay($id)
    {
        $user = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($user);

        $model = new Payment();
        $model->payment_user_id = $id;
        if ($model->pay()) {
            $this->setSuccessFlash();
            $this->redirect(['user/view', 'id' => $id]);
        }

        $this->view->title = $user->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('pay', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlock($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $model->user_date_block = 7 * 86400 + time();
            if ($model->save(true, ['user_date_block', 'user_block_block_reason_id'])) {
                foreach ($model->team as $team) {
                    $team->managerFire();
                }
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockChat($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_chat = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_chat_block_reason_id', 'user_date_block_chat'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-chat', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockComment($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_comment = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_comment_block_reason_id', 'user_date_block_comment'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-comment', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockCommentDeal($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_comment_deal = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_comment_deal_block_reason_id', 'user_date_block_comment_deal'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-comment-deal', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockCommentGame($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_comment_game = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_comment_game_block_reason_id', 'user_date_block_comment_game'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-comment-game', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockCommentNews($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_comment_news = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_comment_news_block_reason_id', 'user_date_block_comment_news'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-comment-news', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionBlockForum($id)
    {
        $model = User::find()->where(['user_id' => $id])->limit(1)->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post())) {
            $time = 1;
            if ($model->user_block_count_date > time() - 30 * 24 * 60 * 60) {
                $time = $model->user_block_count + 1;
            }
            $model->user_block_count = $time;
            $model->user_block_count_date = time();
            $model->user_date_block_forum = $time * 86400 + time();
            if ($model->save(true, ['user_block_count', 'user_block_count_date', 'user_block_forum_block_reason_id', 'user_date_block_forum'])) {
                $this->setSuccessFlash();
                return $this->redirect(['user/view', 'id' => $model->user_id]);
            }
        }

        $blockReasonArray = BlockReason::find()->all();
        $blockReasonArray = ArrayHelper::map($blockReasonArray, 'block_reason_id', 'block_reason_text');

        $this->view->title = $model->user_login;
        $this->view->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('block-forum', [
            'blockReasonArray' => $blockReasonArray,
            'model' => $model,
        ]);
    }
}
