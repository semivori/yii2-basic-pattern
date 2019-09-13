<?php
namespace app\assets\bootstrap4;

use yii\web\AssetBundle;

/**
 * Class CSSAsset
 * @package app\assets\bootstrap4
 */
class CSSAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'themes/bootstrap4/css/chosen-bootstrap.css',
        'themes/bootstrap4/css/narrow-jumbotron.css',
        'themes/bootstrap4/css/app.css',
    ];

    public $js = [

    ];

    public $depends = [

    ];

}
