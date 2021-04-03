<?php

namespace denchotsanov\widget;

use denchotsanov\widget\asset\DropZoneAsset;
use yii\helpers\Html;
use yii\helpers\Json;

class DropZone extends \yii\base\Widget {

    /**
     * @var array An array of options that are supported by Dropzone
     */
    public $options = [];

    /**
     * @var array An array of client events that are supported by Dropzone
     */
    public $clientEvents = [];

    //Default Values
    public $id = 'myDropzone';
    public $uploadUrl = '/site/upload';
    public $dropzoneContainer = 'myDropzone';
    public $previewsContainer = 'previews';
    public $autoDiscover = false;


    public function init()
    {
        parent::init();

        //set defaults
        if (!isset($this->options['url'])) $this->options['url'] = $this->uploadUrl; // Set the url
        if (!isset($this->options['previewsContainer'])) $this->options['previewsContainer'] = '#' . $this->previewsContainer; // Define the element that should be used as click trigger to select files.
        if (!isset($this->options['clickable'])) $this->options['clickable'] = true; // Define the element that should be used as click trigger to select files.
        $this->autoDiscover = $this->autoDiscover===false? 'false' : 'true' ;

        if(\Yii::$app->getRequest()->enableCsrfValidation){
            $this->options['headers'][\yii\web\Request::CSRF_HEADER] = \Yii::$app->getRequest()->getCsrfToken();
            $this->options['params'][\Yii::$app->getRequest()->csrfParam] = \Yii::$app->getRequest()->getCsrfToken();
        }

        \Yii::setAlias('@dropzone', dirname(__FILE__));
        $this->registerAssets();
    }

    public function run()
    {
        return Html::tag('div', $this->renderDropzone(), ['id' => $this->dropzoneContainer, 'class' => 'dropzone']);
    }

    private function renderDropzone()
    {
        return Html::tag('div', '', ['id' => $this->previewsContainer,'class' => 'dropzone-previews']);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $option = Json::encode($this->options);
        $js = <<<JS
        Dropzone.autoDiscover = $this->autoDiscover ;
        
        var $this->id = new Dropzone("#$this->dropzoneContainer", $option );

JS;

        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js .= "$this->id.on('$event', $handler);";
            }
        }

        $view->registerJs($js);
        DropZoneAsset::register($view);
    }

}
