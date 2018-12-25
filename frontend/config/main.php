<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            \yii\i18n\Formatter::class => [
                'numberFormatterOptions' => [
                    NumberFormatter::MIN_SIGNIFICANT_DIGITS => 0,
                ],
            ],
            \yii\grid\GridView::class => [
                'emptyText' => false,
                'options' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive'],
                'pager' => [
                    'activePageCssClass' => 'btn',
                    'options' => [
                        'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top-small',
                        'tag' => 'div',
                    ],
                    'pageCssClass' => 'btn pagination',
                ],
                'tableOptions' => ['class' => 'table table-bordered table-hover'],
            ],
            \yii\widgets\ListView::class => [
                'emptyText' => false,
                'options' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12'],
                'pager' => [
                    'activePageCssClass' => 'btn',
                    'options' => [
                        'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top-small',
                        'tag' => 'div',
                    ],
                    'pageCssClass' => 'btn pagination',
                ],
            ],
            \yii\widgets\LinkPager::class => [
                'class' => \frontend\widgets\LinkPager::class,
            ],
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enableDefaultLanguageUrlCode' => true,
            'enablePrettyUrl' => true,
            'languages' => [
                'ru',
                'ru-*' => 'ru',
            ],
            'rules' => [
                '' => 'site/index',
                'activation' => 'site/activation',
                'activation/repeat' => 'site/activation-repeat',
                'base/build/<building:\d+>' => 'base/build',
                'base/free' => 'base-free/view',
                'base/free/build/<building:\d+>' => 'base-free/build',
                'base/destroy/<building:\d+>' => 'base/destroy',
                'forum/theme/create/<id:\d+>' => 'forum/theme-create',
                'login' => 'site/login',
                'password' => 'site/password',
                'password/restore' => 'site/password-restore',
                'rating/<page:\d+>' => 'rating/index',
                'sign-up' => 'site/sign-up',
                '<controller:\w+>/p/<page:\d+>/pp/<per-page:\d+>' => '<controller>/index',
                '<controller:\w+>/p/<page:\d+>' => '<controller>/index',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>/p/<page:\d+>/pp/<per-page:\d+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>/p/<page:\d+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => 'common\models\User',
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
    ],
    'id' => 'app-frontend',
    'params' => $params,
];
