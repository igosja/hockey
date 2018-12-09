<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\User;
use yii\filters\AccessControl;

/**
 * Class VipController
 * @package frontend\controllers
 */
class VipController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $count = User::find()
            ->where(['>', 'user_date_vip', HockeyHelper::unixTimeStamp()])
            ->count();

        $this->setSeoTitle('VIP клуб');

        return $this->render('index', [
            'count' => $count,
        ]);
    }
}
