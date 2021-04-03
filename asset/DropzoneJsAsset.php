<?php

namespace denchotsanov\widget\asset;

use yii\web\AssetBundle;

class DropzoneJsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/enyo/dropzone/dist';
    public $js = [
        "min/dropzone.min.js"
    ];

    public $css = [
        "min/dropzone.min.css"
    ];
}
