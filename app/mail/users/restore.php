<?php
use yii\helpers\Url;
use app\models\users\ar\User;
use yii\helpers\Html;

/* @var $title string */
/* @var $user User */
?>

<p>
    Hello, <b><?= Html::encode($user->username) ?></b>!
</p>
<p>
    You have just requested a password restoring on <b><a href="<?= Yii::$app->request->hostInfo ?>" target="_blank"><?= Yii::$app->name ?></a></b>.

    To confirm this action, please open the link: <b><a href="<?= Url::to(['/users/set-new-password', 'code' => $user->password_reset_token], true) ?>" target="_blank">
            <?= Url::to(['/users/set-new-password', 'code' => $user->password_reset_token], true) ?>
        </a></b>.
</p>
<p>
    If you did not request a password reset, simply ignore this message.
</p>
