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
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class NewsController
 * @package frontend\controllers
 */
class NewsController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['delete-comment'],
                'rules' => [
                    [
                        'actions' => ['delete-comment'],
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
        $query = News::find()
            ->with([
                'newsComment',
                'user',
            ])
            ->where(['news_country_id' => 0])
            ->orderBy(['news_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNews'],
            ],
        ]);

        if (!Yii::$app->user->isGuest) {
            User::updateAll(
                ['user_news_id' => News::find()->select(['news_id'])->orderBy(['news_id' => SORT_DESC])->scalar()],
                ['user_id' => Yii::$app->user->id]
            );
        }

        $this->setSeoTitle('Новости');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $news = News::find()->where(['news_id' => $id])->one();
        $this->notFound($news);

        $model = new NewsComment();
        $model->news_comment_news_id = $id;
        if ($model->addComment()) {
            $this->setSuccessFlash('Комментарий успешно сохранён');
            return $this->refresh();
        }

        $query = NewsComment::find()
            ->with([
                'user',
            ])
            ->where(['news_comment_news_id' => $id])
            ->orderBy(['news_comment_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNewsComment'],
            ],
        ]);

        $this->setSeoTitle('Комментарии к новости');

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
    public function actionDeleteComment($id, $newsId)
    {
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
