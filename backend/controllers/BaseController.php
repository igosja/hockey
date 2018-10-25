<?php

namespace backend\controllers;

use common\components\Controller;
use Yii;
use yii\filters\AccessControl;

/**
 * Class BaseController
 * @package backend\controllers
 *
 * @property string $layout
 */
class BaseController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
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
     * @return void
     */
    protected function setSuccessFlash(): void
    {
        Yii::$app->session->setFlash('success', 'Изменения успешно сохранены');
    }
}
