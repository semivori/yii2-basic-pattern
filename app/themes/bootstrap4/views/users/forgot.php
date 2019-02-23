<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\users\forms\RestoreForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model RestoreForm */

$this->title = 'Forgot Password - ' . Yii::$app->name;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'action' => Url::to(['/users/forgot']),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

<h3>Forgot Password</h3>

<div class="row">
    <div class="col-md-12">
        <?= $form
            ->field($model, 'email')
            ->textInput(['class' => 'form-control', 'placeholder' => 'Email...', 'required' => 'required'])
            ->label(false) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Restore', [
        'class' => 'btn btn-lg btn-block btn-primary',
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
