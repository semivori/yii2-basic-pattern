<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\users\forms\RegisterForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model RegisterForm */

$this->title = 'Create an account - ' . Yii::$app->name;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'action' => Url::to(['/users/register']),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

    <h3>Create an account</h3>

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
                ->field($model, 'username')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Username...', 'required' => 'required'])
                ->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model, 'password')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form
                ->field($model, 'repeatPassword')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Confirm password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="accept" id="accept" required> I accept <a target="_blank" href="<?= Url::to(['/site/terms']) ?>">Terms and Privacy Policy</a>
        </label>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Create', [
            'class' => 'btn btn-lg btn-block btn-primary',
        ]) ?>
    </div>

<?php ActiveForm::end(); ?>
