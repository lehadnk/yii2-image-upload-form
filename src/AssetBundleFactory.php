<?php
/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 13/03/2017
 * Time: 11:25 PM
 */

namespace lehadnk\ImageUploadForm;


use yii\base\Exception;
use yii\web\AssetBundle;

class AssetBundleFactory
{

    /**
     * @param $name
     * @return AssetBundle
     * @throws Exception
     */
    static function getAssetBundle($name) {
        if (class_exists($name)) {
            $bundle = new $name;
            if ($bundle instanceof AssetBundle) {
                return new $bundle;
            }
        }

        $defaultName = __NAMESPACE__."\\Assets\\{$name}Asset";

        if (!class_exists($defaultName)) {
            throw new Exception("ImageUploadForm is unable to find asset bundle: $name or $defaultName");
        }

        return new $defaultName();
    }
}