<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\bootstrap4\CSSAsset;
use app\assets\bootstrap4\JSAsset;
use app\assets\bootstrap4\CDNAsset;
use yii\helpers\Url;

CDNAsset::register($this);
CSSAsset::register($this);
JSAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/themes/bootstrap4/favicon.ico">
    <title><?= $this->title ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <?= $this->render('//partials/header'); ?>
    <?= $content ?>
    <?= $this->render('//partials/footer'); ?>
</div>

<?= $this->render('//partials/alert'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
