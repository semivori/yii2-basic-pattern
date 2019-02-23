<?php
namespace app\assets\bootstrap4;

use yii\web\AssetBundle;

/**
 * Class CDNAsset
 * @package app\assets\bootstrap4
 */
class CDNAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.2/chosen.min.css',
    ];

    public $js = [
        'https://code.jquery.com/jquery-2.2.4.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.2/chosen.jquery.min.js',
    ];

    public $depends = [

    ];

}
