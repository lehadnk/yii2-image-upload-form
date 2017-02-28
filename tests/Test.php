<?php

use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 28/02/2017
 * Time: 2:58 AM
 */
class Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    private $webDriver;

    private $appUrl = 'http://yii2-image-uploader.local/index.php?r=site%2Fupload';
    private $webserverUploadDir = '/Users/lehadnk/work/yii2-install/web/uploads/';
    private $yiiInstallDir = '/Users/lehadnk/work/yii2-install/';

    public function setUp() {
        // Setting connection to selenium
        $capabilities = [
            WebDriverCapabilityType::BROWSER_NAME => 'chrome',
        ];
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);

        // Setting Yii2 framework
        require($this->yiiInstallDir.'vendor/autoload.php');
        require($this->yiiInstallDir.'vendor/yiisoft/yii2/Yii.php');
        $config = require($this->yiiInstallDir.'config/web.php');
        (new yii\web\Application($config));
    }

    public function tearDown() {
        parent::tearDown();
        $this->webDriver->quit();
    }

    public function testApp() {
        $this->webDriver->get($this->appUrl);
        $this->assertContains('Image Upload', $this->webDriver->getPageSource());
    }
}
