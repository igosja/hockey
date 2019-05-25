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
    'container' => [
        'definitions' => [
            WysiBB::class => [
                'clientOptions' => [
                    'buttons' => 'bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,code,quote,table,smilebox',
                    'smileList' => [
                        [
                            'img' => '<img src="/img/smiles/268.gif" class="sm">',
                            'bbcode' => ':smile:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/269.gif" class="sm">',
                            'bbcode' => ':sad:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/272.gif" class="sm">',
                            'bbcode' => ':lol:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/196.gif" class="sm">',
                            'bbcode' => ':wow:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/264.gif" class="sm">',
                            'bbcode' => ':yes:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/275.gif" class="sm">',
                            'bbcode' => ':cry:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/278.gif" class="sm">',
                            'bbcode' => ':stupid:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/284.gif" class="sm">',
                            'bbcode' => ':like:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/285.gif" class="sm">',
                            'bbcode' => ':beer:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/298.gif" class="sm">',
                            'bbcode' => ':wall:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/300.gif" class="sm">',
                            'bbcode' => ':dance:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/13.gif" class="sm">',
                            'bbcode' => ':green:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/22.gif" class="sm">',
                            'bbcode' => ':shy:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/28.gif" class="sm">',
                            'bbcode' => ':hi:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/54.gif" class="sm">',
                            'bbcode' => ':boss:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/271.gif" class="sm">',
                            'bbcode' => ':tongue:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/137.gif" class="sm">',
                            'bbcode' => ':hockey:',
                        ],
                        [
                            'img' => '<img src="/img/smiles/142.gif" class="sm">',
                            'bbcode' => ':fight:',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'language' => 'en',
    'timeZone' => 'UTC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
