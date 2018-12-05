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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SendmailTransport',
            ],
        ],
    ],
    'language' => 'en',
    'timeZone' => 'UTC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
