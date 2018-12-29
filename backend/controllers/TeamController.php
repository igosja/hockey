<?php

namespace backend\controllers;

use backend\models\TeamSearch;
use common\models\Stadium;
use common\models\Team;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TeamController
 * @package backend\controllers
 */
class TeamController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Команды';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate(int $id)
    {
        $model = Team::find()->where(['team_id' => $id])->limit(1)->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->redirect(['team/view', 'id' => $model->team_id]);
        }

        $stadiumArray = ArrayHelper::map(
            Stadium::find()
                ->where(['!=', 'stadium_id', 0])
                ->orderBy(['stadium_name' => SORT_ASC])
                ->all(),
            'stadium_id',
            'stadium_name'
        );

        $this->view->title = 'Редактирование команды';
        $this->view->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['team/index']];
        $this->view->params['breadcrumbs'][] = [
            'label' => $model->team_name,
            'url' => ['team/view', 'id' => $model->team_id]
        ];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('update', [
            'model' => $model,
            'stadiumArray' => $stadiumArray,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = Team::find()->where(['team_id' => $id])->limit(1)->one();
        $this->notFound($model);

        $this->view->title = $model->team_name;
        $this->view->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['team/index']];
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
