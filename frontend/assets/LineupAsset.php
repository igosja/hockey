<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Class LineupAsset
 * @package frontend\assets
 */
class LineupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/lineup.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
