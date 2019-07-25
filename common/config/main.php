<?php

use coderlex\wysibb\WysiBB;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@runtime' => '@frontend/runtime',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SendmailTransport',
            ],
            'viewPath' => '@common/mail',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'database' => 0,
            'hostname' => 'localhost',
            'port' => 6379,
        ],
    ],
    'container' => [
        'definitions' => [
            WysiBB::class => [
                'clientOptions' => [
                    'buttons' => 'bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,code,quote,table,smilebox',
                    'smileList' => [
                        [
                            'img' => '<img alt="smile" src="/img/smiles/268.gif" class="sm">',
                            'bbcode' => ':smile:',
                        ],
                        [
                            'img' => '<img alt="sad" src="/img/smiles/269.gif" class="sm">',
                            'bbcode' => ':sad:',
                        ],
                        [
                            'img' => '<img alt="lol" src="/img/smiles/272.gif" class="sm">',
                            'bbcode' => ':lol:',
                        ],
                        [
                            'img' => '<img alt="wow" src="/img/smiles/196.gif" class="sm">',
                            'bbcode' => ':wow:',
                        ],
                        [
                            'img' => '<img alt="yes" src="/img/smiles/264.gif" class="sm">',
                            'bbcode' => ':yes:',
                        ],
                        [
                            'img' => '<img alt="cry" src="/img/smiles/275.gif" class="sm">',
                            'bbcode' => ':cry:',
                        ],
                        [
                            'img' => '<img alt="stupid" src="/img/smiles/278.gif" class="sm">',
                            'bbcode' => ':stupid:',
                        ],
                        [
                            'img' => '<img alt="like" src="/img/smiles/284.gif" class="sm">',
                            'bbcode' => ':like:',
                        ],
                        [
                            'img' => '<img alt="beer" src="/img/smiles/285.gif" class="sm">',
                            'bbcode' => ':beer:',
                        ],
                        [
                            'img' => '<img alt="wall" src="/img/smiles/298.gif" class="sm">',
                            'bbcode' => ':wall:',
                        ],
                        [
                            'img' => '<img alt="dance" src="/img/smiles/300.gif" class="sm">',
                            'bbcode' => ':dance:',
                        ],
                        [
                            'img' => '<img alt="green" src="/img/smiles/13.gif" class="sm">',
                            'bbcode' => ':green:',
                        ],
                        [
                            'img' => '<img alt="shy" src="/img/smiles/22.gif" class="sm">',
                            'bbcode' => ':shy:',
                        ],
                        [
                            'img' => '<img alt="hi" src="/img/smiles/28.gif" class="sm">',
                            'bbcode' => ':hi:',
                        ],
                        [
                            'img' => '<img alt="boss" src="/img/smiles/54.gif" class="sm">',
                            'bbcode' => ':boss:',
                        ],
                        [
                            'img' => '<img alt="tongue" src="/img/smiles/271.gif" class="sm">',
                            'bbcode' => ':tongue:',
                        ],
                        [
                            'img' => '<img alt="hockey" src="/img/smiles/137.gif" class="sm">',
                            'bbcode' => ':hockey:',
                        ],
                        [
                            'img' => '<img alt="fight" src="/img/smiles/142.gif" class="sm">',
                            'bbcode' => ':fight:',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'language' => 'ru',
    'timeZone' => 'UTC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
