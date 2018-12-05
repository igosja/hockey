<?php

return [
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=igosj939_virtual_hockey',
            'enableSchemaCache' => true,
            'password' => 'aZGXHM83ZyR6UFx',
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 86400,
            'username' => 'igosj939_hockey',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.virtual-hockey.org',
                'username' => 'info@virtual-hockey.org',
                'password' => 'rxttgRhOKztb1UI',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
];
