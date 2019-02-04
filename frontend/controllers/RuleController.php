<?php

namespace frontend\controllers;

use common\models\Rule;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class RuleController
 * @package frontend\controllers
 */
class RuleController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $rule = Rule::find()
            ->orderBy(['rule_order' => SORT_ASC])
            ->all();

        $this->setSeoTitle('Правила');

        return $this->render('index', [
            'rule' => $rule,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $rule = Rule::find()
            ->where(['rule_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($rule);

        $this->setSeoTitle($rule->rule_title . ' - Правила');

        return $this->render('view', [
            'rule' => $rule,
        ]);
    }

    /**
     * @return string
     */
    public function actionSearch()
    {
        $query = Rule::find()
            ->filterWhere(['like', 'rule_text', Yii::$app->request->get('q')])
            ->orderBy(['rule_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Результаты поиска - Правила');

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
