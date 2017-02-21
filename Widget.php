<?php

namespace lehadnk\ImageUploadForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * This is just an example.
 */
class Widget extends \yii\base\Widget
{

    public $options = [];

    public function run()
    {
        AdminLTEAsset::register($this->getView());

        $id = 'image-upload-form'.$this->id;
        $options = Json::encode($this->options);

        echo Html::tag('div', '', ['id' => $id]);

        $this->view->registerJs("jQuery('#$id').imageUploadForm($options);");
    }
}