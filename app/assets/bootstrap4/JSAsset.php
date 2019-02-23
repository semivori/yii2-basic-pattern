<?php
namespace app\assets\bootstrap4;

use yii\web\AssetBundle;

/**
 * Class JSAsset
 * @package app\assets\bootstrap4
 */
class JSAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [

    ];

    public $js = [
        '/themes/bootstrap4/js/common.js',
    ];

    public $depends = [

    ];

}
