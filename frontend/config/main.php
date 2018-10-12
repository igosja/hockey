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
                'en',
                'en-*' => 'en',
                'ru',
                'ru-*' => 'ru',
                'uk',
                'uk-*' => 'uk',
            ],
            'rules' => [
                '' => 'site/index',
                'activation' => 'site/activation',
                'activation-repeat' => 'site/activation-repeat',
                'login' => 'site/login',
                'news' => 'news/index',
                'password' => 'site/password',
                'password-restore' => 'site/password-restore',
                'rules' => 'rule/index',
                'rule/<id:\d+>' => 'rule/view',
                'schedule/<id:\d+>' => 'schedule/view',
                'schedule' => 'schedule/index',
                'sign-up' => 'site/sign-up',
                'tournaments' => 'tournament/index',
                'transfer' => 'transfer/index',
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
