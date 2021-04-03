<?php

namespace denchotsanov\widget\asset;

use yii\web\AssetBundle;

class DropZoneAsset extends AssetBundle
{

    public $depends = [
        'denchotsanov\widget\asset\DropzoneJsAsset'
    ];
}
