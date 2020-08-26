<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin/bootstrap.min.css',
        'css/admin/style.css',
        'css/admin/style-responsive.css',
        'css/admin/font.css',
        'css/admin/font-awesome.css',
        'css/admin/morris.css',
        'css/admin/monthly.css'


    ];
    public $js = [
        /*'js/admin/jquery2.0.3.min.js',*/
        'js/admin/raphael-min.js',
        'js/admin/morris.js',
        'js/admin/bootstrap.js',
        'js/admin/jquery.dcjqaccordion.2.7.js',
        'js/admin/scripts.js?ver?ver=1.3',
        'js/admin/jquery.slimscroll.js',
        'js/admin/jquery.nicescroll.js',
        'js/admin/jquery.scrollTo.js',
        'js/admin/monthly.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}