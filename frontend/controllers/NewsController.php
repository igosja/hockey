<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\News;
use common\models\NewsComment;
use common\models\User;
use common\models\UserRole;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\Response;

/**
 * Class NewsController
 * @package frontend\controllers
 */
class NewsController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = News::find()
            ->with([
                'newsComment' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['news_comment_news_id']);
                },
                'user' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['user_id', 'user_login']);
                },
            ])
            ->select(['news_id', 'news_date', 'news_text', 'news_title', 'news_user_id'])
            ->where(['news_country_id' => 0])
            ->orderBy(['news_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => News::PAGE_LIMIT,
            ],
        ]);

        $this->view->title = 'Новости';
        $this->setSeoDescription();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $news = News::find()->where(['news_id' => $id])->one();
        $this->notFound($news);

        $model = new NewsComment();
        if ($model->load(Yii::$app->request->post())) {
            $model->news_comment_news_id = $id;
            if ($model->save()) {
                $this->setSuccessFlash('Комментарий успешно сохранён');
                return $this->refresh();
            }
        }

        $query = NewsComment::find()
            ->with([
                'user' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['user_id', 'user_login']);
                }
            ])
            ->select([
                'news_comment_id',
                'news_comment_date',
                'news_comment_news_id',
                'news_comment_text',
                'news_comment_user_id',
            ])
            ->where(['news_comment_news_id' => $id])
            ->orderBy(['news_comment_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => NewsComment::PAGE_LIMIT,
            ],
        ]);

        $this->view->title = 'Комментарии к новости';
        $this->setSeoDescription();

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'news' => $news,
        ]);
    }

    /**
     * @param int $id
     * @param int $newsId
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteComment(int $id, int $newsId): Response
    {
        if (Yii::$app->user->isGuest) {
            $this->forbiddenRole();
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if (UserRole::ADMIN != $user->user_user_role_id) {
            $this->forbiddenRole();
        }

        $model = NewsComment::find()
            ->where(['news_comment_id' => $id, 'news_comment_news_id' => $newsId])
            ->limit(1)
            ->one();

        $this->notFound($model);

        try {
            $model->delete();
            $this->setSuccessFlash('Комментарий успешно удалён.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['news/view', 'id' => $newsId]);
    }
}
