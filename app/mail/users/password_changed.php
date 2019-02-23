<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\user\models\User;

/* @var $title string */
/* @var $user User */
/* @var $password string */
?>

<p>
    Hello, <b><?= Html::encode($user->username) ?></b>!
</p>
<p>
    You changed your password on <b><a href="<?= Yii::$app->request->hostInfo ?>" target="_blank"><?= Yii::$app->name ?></a></b>.
    Please see your credentials below.
    After the next login to the platform, we highly recommend you to <b>change the password</b>.
</p>

<p>
    Your email: <b><?= Html::encode($user->email) ?></b>
    <br>
    Your new password: <b><?= Html::encode($password) ?></b>
</p>

