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
    protected $webDirPath;
    protected $serverPath;

    public function getServerPath()
    {
        return $this->serverPath;
    }

    public function getWebDirPath()
    {
        return $this->webDirPath;
    }

    public function getImages()
    {
        if (!file_exists($this->getServerPath())) {
            return [];
        }

        $images = [];
        $files = new \RecursiveDirectoryIterator($this->getServerPath(), \RecursiveDirectoryIterator::SKIP_DOTS);
        foreach ($files as $file) {
            if ($file->isFile()) {
                if (!in_array($file->getExtension(), [
                    'png', 'jpg', 'jpeg', 'bmp', 'gif'
                ])) continue;

                $images[] = [
                    'id' => $file->getFilename(),
                    'imageUrl' => $this->getWebDirPath().$file->getFilename(),
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
                $path = $this->getServerPath().$name;

                if (!file_exists($this->getServerPath())) {
                    FileHelper::createDirectory($this->getServerPath(), 0777, true);
                }

                $image->saveAs($path);
            } catch (Exception $e) {
                return ['status' => false];
            }

            return [
                'status' => true,
                'src' => $this->getWebDirPath().$name,
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

            if (file_exists($this->getServerPath().$file)) {
                unlink($this->getServerPath().$file);
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