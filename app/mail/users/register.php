<?php
use yii\helpers\Url;
use app\modules\user\models\User;
use yii\helpers\Html;

/* @var $title string */
/* @var $user User */
?>

<p>
    Hello, <b><?= Html::encode($user->username) ?></b>!
    Nice to meet you.
</p>
<p>
    Thank you for registration on <b><a href="<?= Yii::$app->request->hostInfo ?>" target="_blank"><?= Yii::$app->name ?></a></b>!
    We hope our service will be helpful for you.
</p>
<p>
    Your email: <b><?= Html::encode($user->email) ?></b>
    <br>
    Your username: <b><?= Html::encode($user->username) ?></b>
</p>
<p>
    Please confirm your email address, click <b><a href="<?= Url::to(['/users/confirm', 'code' => $user->getConfirmAccountCode()], true) ?>">the link</a></b>.
    Until this action, you will not be able to manage your account and application.
</p>
