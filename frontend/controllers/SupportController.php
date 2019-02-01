<?php

namespace frontend\controllers;

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Support;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

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
            'supportArray' => array_reverse($supportArray),
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function actionLoad()
    {
        $supportArray = Support::find()
            ->where(['support_user_id' => Yii::$app->user->id])
            ->offset(Yii::$app->request->get('offset'))
            ->limit(Yii::$app->request->get('limit'))
            ->orderBy(['support_id' => SORT_DESC])
            ->all();
        $supportArray = array_reverse($supportArray);

        $countSupport = Support::find()
            ->where(['support_user_id' => Yii::$app->user->id])
            ->count();

        if ($countSupport > count($supportArray) + Yii::$app->request->get('offset')) {
            $lazy = 1;
        } else {
            $lazy = 0;
        }

        $list = '';

        foreach ($supportArray as $support) {
            /**
             * @var Support $support
             */
            $list = $list
                . '<div class="row margin-top"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">'
                . FormatHelper::asDateTime($support->support_date)
                . ', '
                . ($support->support_question ? $support->user->userLink() : $support->admin->userLink())
                . '</div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message '
                . ($support->support_question ? 'message-from-me' : 'message-to-me')
                . '">'
                . HockeyHelper::bbDecode($support->support_text)
                . '</div></div>';
        }

        $result = [
            'offset' => Yii::$app->request->get('offset') + Yii::$app->request->get('limit'),
            'lazy' => $lazy,
            'list' => $list,
        ];

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
