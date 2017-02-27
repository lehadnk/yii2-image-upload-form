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
    public function __construct($webDirPath = 'uploads/', $serverPath = null)
    {
        $this->webDirPath = $webDirPath;
        $this->serverPath = ($serverPath === null) ? $webDirPath : $serverPath;
    }
}