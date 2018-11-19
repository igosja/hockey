<?php

namespace frontend\controllers;

use Yii;

/**
 * Class StoreController
 * @package frontend\controllers
 */
class StoreController extends AbstractController
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

        $user = Yii::$app->user->identity;

        $this->setSeoTitle('Магазин');

        return $this->render('index', [
            'user' => $user
        ]);
    }
}
