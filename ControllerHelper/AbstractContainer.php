<?php
/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 26/02/2017
 * Time: 7:47 AM
 */

namespace lehadnk\ImageUploadForm\ControllerHelper;

use yii\base\Object;
use yii\helpers\FileHelper;
use yii\validators\ImageValidator;
use yii\web\UploadedFile;
use yii\web\Response;

abstract class AbstractContainer extends Object
{

    abstract function getImageDir();

    public function getImages()
    {
        if (!file_exists($this->getImageDir())) {
            return [];
        }

        $images = [];
        $files = new \RecursiveDirectoryIterator($this->getImageDir(), \RecursiveDirectoryIterator::SKIP_DOTS);
        foreach ($files as $file) {

            if ($file->isFile()) {
                if (!in_array($file->getExtension(), [
                    'png', 'jpg', 'jpeg', 'bmp', 'gif'
                ])) continue;

                $images[] = [
                    'id' => $file->getFilename(),
                    'imageUrl' => $file->getPathname(),
                ];
            }
        }

        return $images;
    }

    public function actionUploadImage()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $validator = new ImageValidator();
        $image = UploadedFile::getInstanceByName('file');

        if ($validator->validate($image)) {
            try {
                $name = uniqid(date('dmy')) . '.' . $image->getExtension();
                $path = $this->getImageDir().$name;

                if (!file_exists($this->getImageDir())) {
                    FileHelper::createDirectory($this->getImageDir(), 0777, true);
                }

                $image->saveAs($path);
            } catch (Exception $e) {
                return ['status' => false];
            }

            return [
                'status' => true,
                'src' => $path,
                'id' => $name,
            ];
        }

        return ['status' => false];
    }

    public function actionDeleteImage()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $file = \Yii::$app->request->post('id');

            if (file_exists($this->getImageDir().$file)) {
                unlink($this->getImageDir().$file);
                return ['status' => true];
            } else {
                return [
                    'status' => true,
                    'error' => 'Unable to find this image',
                ];
            }
        } catch (Exception $e) {
            return ['status' => false];
        }
    }

}