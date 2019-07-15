<?php

return [
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=vhol',
            'enableSchemaCache' => true,
            'password' => 'zuI2QbJJ',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 10,
            'username' => 'vhol',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'viewPath' => '@common/mail',
        ],
    ],
];
