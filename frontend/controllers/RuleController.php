<?php

namespace frontend\controllers;

use common\models\Rule;

/**
 * Class RuleController
 * @package frontend\controllers
 */
class RuleController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
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
    public function actionView($id): string
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
}
