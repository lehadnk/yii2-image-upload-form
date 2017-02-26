<?php
/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 26/02/2017
 * Time: 7:45 AM
 */

namespace lehadnk\ImageUploadForm\ControllerHelper;

class DirectoryBasedContainer extends AbstractContainer
{

    /**
     * Directory containing an images
     * @var string
     */
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function getImageDir()
    {
        return $this->dir;
    }
}