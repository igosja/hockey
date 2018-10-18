<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@runtime' => '@frontend/runtime',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'basePath' => '@common/messages',
                    'class' => 'yii\i18n\PhpMessageSource',
                    'on missingTranslation' => [
                        'common\components\TranslationEventHandler',
                        'handleMissingTranslation'
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
    ],
    'language' => 'en',
    'timeZone' => 'Europe/Kiev',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
