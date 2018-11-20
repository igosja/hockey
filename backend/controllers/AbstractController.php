<?php

namespace backend\controllers;

use common\components\Controller;
use yii\filters\AccessControl;

/**
 * Class AbstractController
 * @package backend\controllers
 *
 * @property string $layout
 */
abstract class AbstractController extends Controller
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
