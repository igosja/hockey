<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAsset
 * @package backend\assets
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sb-admin-2.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
