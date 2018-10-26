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

        $this->setSeoTitle('Правила');

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

        $this->setSeoTitle($rule->rule_title . ' - Правила');

        return $this->render('view', [
            'rule' => $rule,
        ]);
    }
}
