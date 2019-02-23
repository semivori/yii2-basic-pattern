<?php
use yii\helpers\Url;

/* @var $this \yii\web\View */
?>
<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills float-right">
            <li class="nav-item">
                <?php $isActive = (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'); ?>
                <a class="nav-link <?php if ($isActive) { ?>active<?php } ?>" href="<?= Url::to(['/']) ?>">Home <?php if ($isActive) { ?><span class="sr-only">(current)</span><?php } ?></a>
            </li>
            <li class="nav-item">
                <?php $isActive = (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'about'); ?>
                <a class="nav-link <?php if ($isActive) { ?>active<?php } ?>" href="<?= Url::to(['/site/about']) ?>">About <?php if ($isActive) { ?><span class="sr-only">(current)</span><?php } ?></a>
            </li>
            <li class="nav-item">
                <?php $isActive = (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'contact'); ?>
                <a class="nav-link <?php if ($isActive) { ?>active<?php } ?>" href="<?= Url::to(['/site/contact']) ?>">Contact <?php if ($isActive) { ?><span class="sr-only">(current)</span><?php } ?></a>
            </li>
        </ul>
    </nav>
    <h3 class="text-muted">Project name</h3>
</div>
