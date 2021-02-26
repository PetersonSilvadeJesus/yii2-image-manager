<?php
namespace petersonsilvadejesus\imagemanager\assets;

use yii\web\AssetBundle;

class LinkPagerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/petersonsilvadejesus/yii2-image-manager/assets/source';

    public $js = [
        'js/link_pager.js'
    ];

    public $css = [
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}