<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $css = [
//        'css/site.css',
//    ];
//    public $js = [
//    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
//        'app\assets\MyAppAsset',
    ];

    public $css = [
        'css/site.css',
//        'css/ie.css',
    ];
    public $cssOptions = [
        //аттрибут condition для тэга link (отлько для <= IE8)
//        'condition' => 'lte IE8'
    ];
    public $js = [
//        'js/file.js',
//        '//vk.com/js/api/openapi.js',
    ];
}
