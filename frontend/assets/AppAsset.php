<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/breadcrumbs.css',
        'css/nprogress.css'
    ];
    public $js = [
        'js/bootbox.min.js',
        'js/main.js',
        'js/jquery.validate.min.js',
        'js/nprogress.js',
        'https://code.jquery.com/ui/1.11.3/jquery-ui.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}