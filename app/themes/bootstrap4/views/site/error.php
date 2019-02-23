<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '=( ' . Html::encode($name);
?>
<div class="row">
    <div class="col-sm-12">
        <h3>
            <?= nl2br(Html::encode($message)) ?>
            Please contact us if you think this is a server error. Thank you.
        </h3>
    </div>
</div>
