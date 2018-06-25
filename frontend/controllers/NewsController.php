<?php

namespace frontend\controllers;

use common\models\News;
use yii\data\ActiveDataProvider;

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
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['news_country_id' => 0])->orderBy(['news_id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => News::PAGE_LIMIT,
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
