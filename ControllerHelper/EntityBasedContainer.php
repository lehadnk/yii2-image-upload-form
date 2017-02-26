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

    private $baseDir;

    public function __construct(ActiveRecord $entity, $baseDir = 'uploads/')
    {
        $this->entity = $entity;
        $this->baseDir = $baseDir;
    }

    public function getImageDir()
    {
        return $this->baseDir.$this->entity->formName().'/'.$this->entity->getPrimaryKey().'/';
    }
}