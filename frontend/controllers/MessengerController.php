<?php

namespace frontend\controllers;

use Yii;

/**
 * Class MessengerController
 * @package frontend\controllers
 */
class MessengerController extends AbstractController
{
    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->forbiddenAuth();
        }

        $this->setSeoTitle('Личные сообщения');

        return $this->render('index');
    }
}
