<?php

namespace backend\controllers;

use backend\models\SupportSearch;
use backend\models\SupportUserSearch;
use common\models\Support;
use Exception;
use Yii;
use yii\web\Response;

/**
 * Class SupportController
 * @package backend\controllers
 */
class SupportController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupportUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Техподдержка';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Exception
     */
    public function actionView($id)
    {
        $support = Support::find()
            ->where(['support_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($support);

        $model = new Support();
        if ($model->addAnswer($support)) {
            $this->setSuccessFlash();
            return $this->refresh();
        }

        $searchModel = new SupportSearch();
        $dataProvider = $searchModel->search([
            'support_user_id' => $support->support_user_id,
            'support_country_id' => $support->support_country_id,
        ]);

        Support::updateAll(
            ['support_read' => time()],
            ['support_read' => 0, 'support_question' => 1, 'support_user_id' => $support->support_user_id, 'support_inside' => 0]
        );

        $this->view->title = 'Техподдержка';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'user' => $support->user,
        ]);
    }
}
