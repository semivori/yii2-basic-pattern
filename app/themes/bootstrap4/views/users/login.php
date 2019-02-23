<?php
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\users\forms\LoginForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model LoginForm */

$this->title = 'Login - ' . Yii::$app->name;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'action' => Url::to(['/users/login']),
    'enableClientScript' => false,
    'options' => ['role' => 'form'],
]); ?>

    <h3>Login</h3>

    <div class="row">
        <div class="col-md-6">
            <?= $form
                ->field($model, 'email')
                ->textInput(['class' => 'form-control', 'placeholder' => 'Email...', 'required' => 'required'])
                ->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form
                ->field($model, 'password')
                ->passwordInput(['class' => 'form-control', 'placeholder' => 'Password...', 'required' => 'required'])
                ->label(false) ?>
        </div>
    </div>

    <div class="form-group clearfix">
        <p>
            <a href="<?= Url::to(['/users/forgot']) ?>">Forgot Password?</a>
            <br>
            Don't have an account? <a href="<?= Url::to(['/users/register']) ?>">Create it!</a>
        </p>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Login', [
            'class' => 'btn btn-lg btn-block btn-primary',
        ]) ?>
    </div>

<?php ActiveForm::end(); ?>
