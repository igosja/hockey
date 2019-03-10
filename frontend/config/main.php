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
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/jquery-1.10.0.min.js',
                    ]
                ],
            ],
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
                'country/news/create/<id:\d+>' => 'country/news-create',
                'country/news/comment/delete/<id:\d+>/<newsId:\d+>' => 'country/delete-news-comment',
                'country/news/delete/<id:\d+>/<newsId:\d+>' => 'country/news-delete',
                'country/news/update/<id:\d+>/<newsId:\d+>' => 'country/news-update',
                'country/news/view/<id:\d+>/<newsId:\d+>' => 'country/news-view',
                'country/poll/create/<id:\d+>' => 'country/poll-create',
                'country/poll/delete/<id:\d+>/<pollId:\d+>' => 'country/poll-delete',
                'forum/message/delete/<id:\d+>' => 'forum/message-delete',
                'forum/message/move/<id:\d+>' => 'forum/message-move',
                'forum/message/update/<id:\d+>' => 'forum/message-update',
                'forum/theme/create/<id:\d+>' => 'forum/theme-create',
                'lineup/national/<id:\d+>' => 'lineup-national/view',
                'login' => 'site/login',
                'password' => 'site/password',
                'password/restore' => 'site/password-restore',
                'rating/<page:\d+>' => 'rating/index',
                'sign-up' => 'site/sign-up',
                'training/free' => 'training-free/index',
                'training/free/train' => 'training-free/train',
                'user/money-transfer/<id:\d+>' => 'user/money-transfer',
                'visitor/national/<id:\d+>' => 'visitor-national/view',
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
