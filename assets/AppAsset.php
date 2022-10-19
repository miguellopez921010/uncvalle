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
        'css/site.css',
        'css/general.css',
        'css/bootstrap.min.css',
        'css/jquery-ui.min.css',  
        'css/jquery-ui.structure.min.css',
        'css/jquery-ui.theme.min.css',
        'css/jquery.bxslider.css'
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js', 
        'js/jquery-ui.min.js', 
        'js/general.js', 
        'js/sweetalert.min.js',
        'js/jquery.blockUI.js',   
        'js/jquery.bxslider.min.js',
        'js/ckeditor/ckeditor.js',
    ];

    /*public $css = [        
        'css/general.css',
        'css/site.css',
        'css/jquery-ui.min.css',  
        'css/jquery-ui.structure.min.css',
        'css/jquery-ui.theme.min.css',
        'css/jquery.bxslider.css',
        'css/dropzone.css',                
    ];
    public $js = [
        'js/general.js',
        'js/jquery.min.js',         
        'js/jquery-ui.min.js',         
        'js/sweetalert.min.js',
        'js/jquery.blockUI.js',   
        'js/jquery.bxslider.min.js',
        //'js/dropzone.js',         
    ];*/
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',        
    ];
}
