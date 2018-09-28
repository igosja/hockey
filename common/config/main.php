<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@runtime' => '@frontend/runtime',
    ],
    'language' => 'en',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'basePath' => '@common/messages',
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                    'on missingTranslation' => [
                        'common\components\TranslationEventHandler',
                        'handleMissingTranslation'
                    ],
                ],
            ],
        ],
    ],
];
