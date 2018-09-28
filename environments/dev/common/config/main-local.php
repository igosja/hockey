<?php

$config = [
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=igosja_hockey',
            'enableSchemaCache' => true,
            'password' => 'zuI2QbJJ',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 86400,
            'username' => 'igosja_hockey',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'viewPath' => '@common/mail',
        ],
    ],
];

if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
