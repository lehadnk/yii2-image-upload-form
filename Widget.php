<?php

namespace lehadnk\ImageUploadForm;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is just an example.
 */
class Widget extends \yii\base\Widget {

    public $options = [];

    public $preloadImages = [];

    public function run() {
        AdminLTEAsset::register($this->getView());

        $id = 'image-upload-form'.$this->id;
        $options = Json::encode($this->options);

        $images = $this->loadImages();

        echo Html::tag('div', $images, ['id' => $id]);

        $this->view->registerJs("jQuery('#$id').imageUploadForm($options);");
    }

    public function loadImages() {
        $images = '';

        foreach ($this->preloadImages as $image) {
            if (!isset($image['imageUrl'])) {
                throw new Exception("Error parsing the preloadImages block: no imageUrl set!");
            }
            if (!isset($image['id'])) {
                throw new Exception("Error parsing the preloadImages block: no id set!");
            }

            $images .= Html::tag('img', '', [
                'src' => $image['imageUrl'],
                'data-id' => $image['id']
            ]);
        }

        return $images;
    }
}