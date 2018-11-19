<?php

namespace frontend\controllers;

use common\models\User;
use yii\db\Expression;

/**
 * Class ForumController
 * @package frontend\controllers
 */
class ForumController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $count = User::find()->where(['>', 'user_date_vip', new Expression('UNIX_TIMESTAMP()')])->count();

        $this->setSeoTitle('VIP клуб');

        return $this->render('index', [
            'count' => $count
        ]);
    }
}
