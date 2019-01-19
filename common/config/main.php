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
    'container' => [
        'definitions' => [
            \coderlex\wysibb\WysiBB::class => [
                'clientOptions' => [
                    'buttons' => 'bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,code,quote,table,smilebox',
                    'smileList' => [
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm01.png" class="sm">',
//                            'bbcode' => ':)',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm02.png" class="sm">',
//                            'bbcode' => ':(',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm03.png" class="sm">',
//                            'bbcode' => ':D',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm04.png" class="sm">',
//                            'bbcode' => ';)',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm05.png" class="sm">',
//                            'bbcode' => ':boss:',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm06.png" class="sm">',
//                            'bbcode' => ':applause:',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm07.png" class="sm">',
//                            'bbcode' => ':surprise:',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm08.png" class="sm">',
//                            'bbcode' => ':sick:',
//                        ],
//                        [
//                            'img' => '<img src="{themePrefix}{themeName}/img/smiles/sm09.png" class="sm">',
//                            'bbcode' => ':angry:',
//                        ],
                    ],
                ],
            ],
        ],
    ],
    'language' => 'en',
    'timeZone' => 'UTC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
];
