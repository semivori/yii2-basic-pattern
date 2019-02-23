<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\users\forms\NewPasswordForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model NewPasswordForm */

$this->title = 'Set New Password - ' . Yii::$app->name;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'action' => Url::to(['/users/set-new-password', 'code' => Yii::$app->request->get('code')]),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

<h3>Login</h3>

<div class="row">
    <div class="col-md-6">
        <?= $form
            ->field($model, 'password')
            ->passwordInput(['class' => 'form-control', 'placeholder' => 'New password...', 'required' => 'required'])
            ->label(false) ?>
    </div>
    <div class="col-md-6">
        <?= $form
            ->field($model, 'repeatPassword')
            ->passwordInput(['class' => 'form-control', 'placeholder' => 'Confirm new password...', 'required' => 'required'])
            ->label(false) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Update Password', [
        'class' => 'btn btn-lg btn-block btn-primary',
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
