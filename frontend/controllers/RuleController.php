<?php

namespace frontend\controllers;

use common\models\Rule;

/**
 * Class RuleController
 * @package frontend\controllers
 */
class RuleController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $rules = Rule::find()->orderBy(['rule_order' => SORT_ASC])->all();

        $this->view->title = 'Rules';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Rules - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'rules' => $rules,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id): string
    {
        $rule = Rule::findOne($id);
        $this->notFound($rule);

        $this->view->title = $rule->rule_title . ' - Rules';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $rule->rule_title . ' - Rules - Virtual Hockey Online League'
        ]);

        return $this->render('view', [
            'rule' => $rule,
        ]);
    }
}