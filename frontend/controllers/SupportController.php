<?php

namespace frontend\controllers;

use common\models\Support;
use Yii;
use yii\filters\AccessControl;

/**
 * Class SupportController
 * @package frontend\controllers
 */
class SupportController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = new Support();
        if ($model->addQuestion()) {
            $this->setSuccessFlash('Сообщение успешно сохраненo');
            return $this->refresh();
        }

        $supportArray = Support::find()
            ->where(['support_user_id' => Yii::$app->user->id])
            ->limit(Yii::$app->params['pageSizeMessage'])
            ->orderBy(['support_id' => SORT_DESC])
            ->all();

        $countSupport = Support::find()
            ->where(['support_user_id' => Yii::$app->user->id])
            ->count();

        $lazy = 0;
        if ($countSupport > count($supportArray)) {
            $lazy = 1;
        }

        Support::updateAll(
            ['support_read' => time()],
            ['support_read' => 0, 'support_user_id' => Yii::$app->user->id, 'support_question' => 0]
        );

        $this->setSeoTitle('Техническая поддержка');

        return $this->render('index', [
            'lazy' => $lazy,
            'model' => $model,
            'supportArray' => $supportArray,
        ]);
    }
}
