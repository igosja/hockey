<?php

namespace backend\controllers;

use common\components\Controller;
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
}
