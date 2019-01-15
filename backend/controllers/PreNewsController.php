<?php

namespace backend\controllers;

use common\models\PreNews;
use Yii;

/**
 * Class PreNewsController
 * @package backend\controllers
 */
class PreNewsController extends AbstractController
{
    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = PreNews::find()
            ->where(['pre_news_id' => 1])
            ->limit(1)
            ->one();
        if ($model) {
            $model = new PreNews();
            $model->pre_news_id = 1;
            $model->save();
        }

        $this->view->title = 'Предварительные новости';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate()
    {
        $model = PreNews::find()
            ->where(['pre_news_id' => 1])
            ->limit(1)
            ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['pre-news/index']);
        }

        $this->view->title = 'Редактирование предварительной новости';
        $this->view->params['breadcrumbs'][] = ['label' => 'Предварительные новости', 'url' => ['pre-news/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
