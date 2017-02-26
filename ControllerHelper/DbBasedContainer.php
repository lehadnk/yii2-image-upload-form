<?php
/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 26/02/2017
 * Time: 7:45 AM
 */

namespace lehadnk\ImageUploadForm\ControllerHelper;

use yii\base\Exception;
use yii\web\Response;
use lehadnk\ImageUploadForm\Image;

class DbBasedContainer extends EntityBasedContainer
{
    function actionUploadImage()
    {
        $result = parent::actionUploadImage();
        if ($result['status']) {
            try {
                $image = new Image();
                $image->setOwner($this->entity);
                $image->filename = $result['src'];
                $image->save();

                $result['id'] = $image->getPrimaryKey();
            } catch (Exception $e) {
                unlink($result['src']);
                return ['status' => false];
            }
        }

        return $result;
    }

    public function getImages() {
        $images = Image::findAll([
            'entity_name' => $this->entity->formName(),
            'entity_id' => $this->entity->getPrimaryKey(),
        ]);

        $result = [];
        foreach ($images as $image) {
            $result[] = [
                'imageUrl' => $image->filename,
                'id' => $image->getPrimaryKey(),
            ];
        }

        return $result;
    }

    public function actionDeleteImage()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $image = Image::findOne(\Yii::$app->request->post('id'));

        if ($image) {
            try {
                $image->delete();
                return ['status' => true];
            } catch (Exception $e) {
                return ['status' => false];
            }
        }

        return [
            'status' => true,
            'error' => 'Unable to find this image',
        ];
    }
}