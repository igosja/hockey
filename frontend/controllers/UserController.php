<?php

namespace frontend\controllers;

use common\models\User;
use Yii;

/**
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionView($id = 0)
    {
        if (!$id) {
            if (!Yii::$app->user->isGuest) {
                $id = Yii::$app->user->id;
            } else {
                $id = User::ADMIN_USER_ID;
            }

            return $this->redirect(['user/view', 'id' => $id]);
        }

        $this->setSeoTitle('Профиль пользователя');

        return $this->render('view', [
        ]);
    }
}
