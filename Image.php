<?php

namespace lehadnk\ImageUploadForm;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $entity_name
 * @property int $entity_id
 * @property string $filename
 */
class Image extends ActiveRecord
{

    /**
     * @var ActiveRecord
     */
    public $owner;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_name', 'entity_id'], 'required'],
            [['entity_id'], 'integer'],
            [['entity_name'], 'string', 'max' => 80],
            [['filename'], 'string', 'max' => 300],
            [['filename'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_name' => 'Entity Name',
            'entity_id' => 'Entity ID',
            'filename' => 'Filename',
        ];
    }

    public function setOwner(ActiveRecord $entity) {
        $this->entity_name = $entity->formName();
        $this->entity_id = $entity->getPrimaryKey();
        $this->owner = $entity;
    }

    public function getOwner() {
        if ($this->owner === null) {
            $class = $this->entity_name;
            if (!class_exists($class)) {
                throw new Exception("No such class exists: $class");
            }
            if (!$class instanceof ActiveRecord) {
                throw new Exception("$class should be an instance of ActiveRecord!");
            }

            $this->owner = $class::find($this->entity_id);
        }

        return $this->owner;
    }

    public function delete() {
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }
        parent::delete();
    }
}
