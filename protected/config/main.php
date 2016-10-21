<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'VirHOL',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'defaultController' => 'index',
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=igosja_hockey',
            'emulatePrepare' => true,
            'username' => 'igosja_hockey',
            'password' => 'zuI2QbJJ',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'admin/<controller>/<action>/<id>' => 'admin/<controller>/<action>',
                'admin/<controller>/<action>' => 'admin/<controller>/<action>',
                'admin/<controller>' => 'admin/<controller>/index',
                '<controller>/<action>/<id>' => '<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
                '<controller>' => '<controller>/index',
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CWebLogRoute',
                ),
            ),
        ),
    ),
    'modules' => array(
        'admin',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);