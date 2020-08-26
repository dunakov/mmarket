<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'css/style.css?ver=1.2',
        'css/font-awesome.css',
        /*'https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:100,300,400,500,700,800&display=swap&subset=cyrillic',*/
        'css/flexslider.css',

    ];
    public $js = [
        'js/move-top.js',
        'js/easing.js',
        'js/jquery.flexslider.js',
        'js/bootstrap.min.js',
        'js/main.js?ver?ver=1.4'

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

