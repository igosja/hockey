<?php

namespace frontend\controllers;

use common\models\News;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

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
                'pageSize' => 1,//News::PAGE_LIMIT,
            ],
        ]);

        $this->view->title = 'News';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'News - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
