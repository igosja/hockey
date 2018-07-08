<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => [
                'class' => \common\widgets\LinkPager::class,
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enableDefaultLanguageUrlCode' => true,
            'enablePrettyUrl' => true,
            'languages' => ['en'],
            'rules' => [
                '' => 'site/index',
                'news' => 'news/index',
                'rules' => 'rule/index',
                'rule/<id:\d+>' => 'rule/view',
                'schedule/<id:\d+>' => 'schedule/view',
                'schedule' => 'schedule/index',
                'sign-up' => 'site/sign-up',
                'tournaments' => 'tournament/index',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
    ],
    'params' => $params,
];
