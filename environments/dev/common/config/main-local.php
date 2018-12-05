<?php

return [
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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.beget.com',
                'username' => 'vhol@moviten.com.ua',
                'password' => 'pH%5EQl6',
                'port' => 465,
                'encryption' => 'ssl',
            ],
        ],
    ],
];
