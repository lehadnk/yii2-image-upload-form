Image Upload Form
=================
Responsive multiple image upload form for yii2 framework

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lehadnk/yii2-image-upload-form "*"
```

or add

```
"lehadnk/yii2-image-upload-form": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :
```php
use \yii\helpers\Url;
<?= \lehadnk\ImageUploadForm\Widget::widget([
    'options' => [
        'uploadUrl' => Url::to('image/upload'),
        'deleteUrl' => Url::to('image/delete'),
    ],
    'preloadImages' => [
        [
            'imageUrl' => '/img/14880264751162.jpg',
            'id' => '13',
        ],
        [
           'imageUrl' => '/img/avatar.png',
           'id' => '18', 
        ]
    ]
]); ?>
```