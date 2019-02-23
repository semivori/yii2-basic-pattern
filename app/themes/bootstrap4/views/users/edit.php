<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\users\forms\EditForm;
use app\models\users\forms\PasswordForm;
use app\services\common\TimeZoneService;
use yii\helpers\Url;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model EditForm */
/* @var $passwordModel PasswordForm */

$this->title = 'Edit account - ' . Yii::$app->name;
?>

<?php $form = ActiveForm::begin([
    'id' => 'edit-form',
    'action' => Url::to(['/users/edit']),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

    <h3>Edit account</h3>

    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model, 'firstName')
                ->textInput(['class' => 'form-control', 'placeholder' => 'First name...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form
                ->field($model, 'lastName')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Last name...', 'required' => 'required'])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model, 'email')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Email...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form
                ->field($model, 'phoneNumber')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Phone number...'])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form
                ->field($model, 'timeZone')
                ->dropDownList(TimeZoneService::getList(), ['class' => 'form-control chosen-select', 'prompt' => 'Time zone...', 'options' => [$model->timeZone => ['Selected' => true]]])
                ->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', [
            'class' => 'btn btn-lg btn-block btn-primary',
        ]) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php $form2 = ActiveForm::begin([
    'id' => 'password-form',
    'action' => Url::to(['/users/edit']),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

    <h3>Edit password</h3>

    <div class="row">
        <div class="col-md-4">
            <?= $form2
                ->field($passwordModel, 'password')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Current password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form2
                ->field($passwordModel, 'new')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'New password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form2
                ->field($passwordModel, 'repeat')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Confirm new password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', [
            'class' => 'btn btn-lg btn-block btn-primary',
        ]) ?>
    </div>

<?php ActiveForm::end(); ?>