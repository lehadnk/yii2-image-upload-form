<?php
/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 26/02/2017
 * Time: 7:44 AM
 */

namespace lehadnk\ImageUploadForm\ControllerHelper;

use yii\base\Model;
use yii\db\ActiveRecord;

class EntityBasedContainer extends AbstractContainer
{

    /**
     * @var Model
     */
    protected $entity;

    public function __construct(ActiveRecord $entity, $webDirPath = 'uploads/', $serverPath = null)
    {
        $this->entity = $entity;
        $this->webDirPath = $webDirPath;
        $this->serverPath = ($serverPath === null) ? $webDirPath : $serverPath;
    }

    protected function buildFilePath() {
        return $this->entity->formName().'/'.$this->entity->getPrimaryKey().'/';
    }

    public function getServerPath()
    {
        return $this->serverPath.$this->buildFilePath();
    }

    public function getWebDirPath()
    {
        return $this->webDirPath.$this->buildFilePath();
    }
}