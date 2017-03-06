<?php

use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\LocalFileDetector;

/**
 * Created by PhpStorm.
 * User: lehadnk
 * Date: 28/02/2017
 * Time: 2:58 AM
 */
class Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var RemoteWebDriver
     */
    private $webDriver;

    private $appUrl = 'http://yii2-image-uploader.local/index.php?r=site%2Fupload';
    private $webserverUploadDir = '/Users/lehadnk/work/yii2-install/web/uploads/';
    private $yiiInstallDir = '/Users/lehadnk/work/yii2-install/';
    private $imageFilePath = '/Users/lehadnk/work/imageupload/testimages/14880155323870.jpg';

    public function setUp() {
        // Setting connection to selenium
        $capabilities = [
            WebDriverCapabilityType::BROWSER_NAME => 'chrome',
        ];
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);

        // Setting Yii2 framework
        require_once($this->yiiInstallDir.'vendor/autoload.php');
        require_once($this->yiiInstallDir.'vendor/yiisoft/yii2/Yii.php');
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

    public function testForm() {
        $this->webDriver->get($this->appUrl);
        $input = $this->webDriver->findElement(WebDriverBy::cssSelector('#image-upload-formw0 input[type="file"]'));
        $this->assertTrue($input->isDisplayed());
    }

    public function testUpload() {
        $this->webDriver->get($this->appUrl);
        $input = $this->webDriver->findElement(WebDriverBy::cssSelector('#image-upload-formw0 input[type="file"]'));

        // Calculating the number of the images in upload dir
        $fi = new FilesystemIterator($this->webserverUploadDir, FilesystemIterator::SKIP_DOTS);
        $cnt = iterator_count($fi);

        // Uploading the image
        $input->setFileDetector(new LocalFileDetector());
        $input->sendKeys($this->imageFilePath);
        $this->webDriver->wait(1);

        // Verifying that crc32's of both local and uploaded file are the same
        $recentFileName = $this->getLastUploadedFile($this->webserverUploadDir);
        $this->assertEquals(hash_file('crc32b', $this->imageFilePath), hash_file('crc32b', $recentFileName));
        // Verifying that now we have cnt+1 images in the uploads dir
        $this->assertEquals(iterator_count($fi), $cnt++);
    }

    public function testDelete() {
        $this->webDriver->get($this->appUrl);

        // Calculating the number of the images in upload dir
        $fi = new FilesystemIterator($this->webserverUploadDir, FilesystemIterator::SKIP_DOTS);
        $cnt = iterator_count($fi);

        // Check that delete button is displayed
        $buttons = $this->webDriver->findElements(WebDriverBy::cssSelector('#image-upload-formw0 button'));
        $button = end($buttons);
        $this->assertTrue($button->isDisplayed());

        $button->click();
        $this->webDriver->wait(1);

        // Verifying that now we have cnt-1 images in the uploads dir
        $this->assertEquals(iterator_count($fi), $cnt--);
    }

    /**
     * Returns the full path of the last created file in the directory
     * @param string $dir
     * @return string
     */
    private function getLastUploadedFile($dir) {
        $mostRecentFilePath = "";
        $mostRecentFileMTime = 0;

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {
                if ($fileinfo->getMTime() > $mostRecentFileMTime) {
                    $mostRecentFileMTime = $fileinfo->getMTime();
                    $mostRecentFilePath = $fileinfo->getPathname();
                }
            }
        }

        return $mostRecentFilePath;
    }
}
