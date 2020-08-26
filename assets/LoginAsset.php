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
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
        'css/util.css',
        'css/main.css'
    ];
    public $js = [
        '/assets/d8df0ce0/jquery.js',
        '/assets/8fa755a6/yii.js',
        '/assets/8fa755a6/yii.validation.js',
        '/assets/8fa755a6/yii.activeForm.js',
        'js/mainer.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
