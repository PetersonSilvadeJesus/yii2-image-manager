<?php
namespace petersonsilvadejesus\imagemanager\assets;
use yii\web\AssetBundle;

/**
 * ImageManagerInputAsset.
 */
class ImageManagerInputAsset extends AssetBundle
{
    public $sourcePath = '@vendor/petersonsilvadejesus/yii2-image-manager/assets/source';
    public $css = [
		'css/imagemanager.input.css',
    ];
    public $js = [
        'js/script.imagemanager.input.js',
    ];
    public $depends = [
		'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
