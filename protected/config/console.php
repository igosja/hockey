<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Virtual hockey online league (console)',
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=igosja_hockey',
            'emulatePrepare' => true,
            'username' => 'igosja_hockey',
            'password' => 'zuI2QbJJ',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
    ),
);