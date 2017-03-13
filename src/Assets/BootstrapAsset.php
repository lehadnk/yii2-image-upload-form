<?php

namespace lehadnk\ImageUploadForm\Assets;
use yii\web\AssetBundle;

/**
 * This is just an example.
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/image-upload-form';

    public $css = [
        'build/ImageUploadForm.min.css',
    ];

    public $js = [
        'build/ImageUploadForm.min.js',
        'build/ImageUploadFormBootstrap.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}