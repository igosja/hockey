<?php

return [
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=admin_vhol',
            'enableSchemaCache' => true,
            'password' => 'aZGXHM83ZyR6UFx',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 86400,
            'username' => 'admin_hockey',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'vps47126.hostlife.net',
                'username' => 'info@virtual-hockey.org',
                'password' => 'rxttgRhOKztb1UI',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];
