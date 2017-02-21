<?php

namespace lehadnk\ImageUploadForm;
use yii\web\AssetBundle;

/**
 * This is just an example.
 */
class AdminLTEAsset extends AssetBundle
{
    public $sourcePath = '@bower/image-upload-form';

    public $css = [
        'build/ImageUploadForm.min.css',
    ];

    public $js = [
        'build/ImageUploadForm.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}