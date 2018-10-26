<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\db\Expression;

/**
 * Class CountryController
 * @package frontend\controllers
 */
class VipController extends BaseController
{
    /**
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        if (Yii::$app->user->isGuest) {
            $this->forbiddenAuth();
        }

        $count = User::find()->where(['>', 'user_date_vip', new Expression('UNIX_TIMESTAMP()')])->count();

        $this->view->title = 'VIP клуб';
        $this->setSeoDescription();

        return $this->render('index', [
            'count' => $count
        ]);
    }
}
